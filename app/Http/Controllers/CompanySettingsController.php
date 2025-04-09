<?php

namespace App\Http\Controllers;

use App\Models\CompanySettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Cache;
use Illuminate\Http\Request;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QRImagick;

class CompanySettingsController extends Controller
{


    public function index()
    {   
        return view('pages/tenant/settings/index', ['settings' => CompanySettings::all()]);
    }

    public function saveSettings(Request $request)
    {
        $settings = collect(CompanySettings::select('name', 'value_type')->get()->toArray());
        $validation = [];
        foreach ($settings as $value) {
            switch ($value['value_type']) {
                case 'text':
                    $validation[$value['name']] = 'required|min:1|max:255';
                    break;
                case 'boolean':
                    $validation[$value['name']] = 'nullable';
                    break;
                case 'number':
                    $validation[$value['name']] = 'required|numeric';
                    break;
                case 'date':
                    $validation[$value['name']] = 'required|date_format:m-d';
                    break;
                default:
                    $validation[$value['name']] = 'required';
                    break;
            }
        }

        $attributes = $request->validate($validation);

        foreach ($settings as $setting) {
            $updateQuery = CompanySettings::where('name', $setting['name']);
            if ($setting['value_type'] === 'boolean') {
                $updateQuery->update([
                    'value' => isset($attributes[$setting['name']]),
                ]);
            } else {
                $updateQuery->update([
                    'value' => $attributes[$setting['name']]
                ]);
            }
        }

        Cache::forget('company_settings');
        Cache::rememberForever('company_settings', function () {
            return CompanySettings::select('name','value')->get()->keyBy('name')->toArray();
        });
        
        return redirect('/settings')->with('status', 'Settings Updated!');
    }

    public function qrCode(Request $request)
    {

        $data = url('/system/clockIn');

        $options = new QROptions;

        $options->version = 6;
        $options->outputInterface = QRImagick::class;
        $options->imagickFormat = 'webp';
        $options->quality = 90;
        $options->scale = 20;
        $options->outputBase64 = true;
        $options->bgColor = '#ccccaa';
        $options->imageTransparent = true;
        $options->transparencyColor = '#ccccaa';
        $options->keepAsSquare = [
            QRMatrix::M_FINDER_DARK,
            QRMatrix::M_FINDER_DOT,
            QRMatrix::M_ALIGNMENT_DARK,
        ];

        $qrCode = (new QRCode($options))->render($data);

        return view('pages.tenant.settings.qrCode', ['qrCode' => $qrCode]);
    }

    public function shareQrCode(Request $request)
    {

        $data = url('/system/clockIn');

        $options = new QROptions;

        $options->version = 6;
        $options->outputInterface = QRImagick::class;
        $options->imagickFormat = 'webp';
        $options->quality = 90;
        $options->scale = 20;
        $options->outputBase64 = true;
        $options->bgColor = '#ccccaa';
        $options->imageTransparent = true;
        $options->transparencyColor = '#ccccaa';
        $options->keepAsSquare = [
            QRMatrix::M_FINDER_DARK,
            QRMatrix::M_FINDER_DOT,
            QRMatrix::M_ALIGNMENT_DARK,
        ];


        $qrCode = (new QRCode($options))->render($data);

        $PDF = Pdf::loadView('exports.qrCode.share', ['qrCode' => $qrCode]);
        return $PDF->stream();
    }
}
