<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    /**
     * All certifications, each with a download when its document has been uploaded.
     */
    public function index()
    {
        $certifications = Certification::active()->get();

        return view('store.certifications', compact('certifications'));
    }

    /**
     * Download one certificate document.
     */
    public function download(Certification $certification)
    {
        abort_unless($certification->status && $certification->hasFile(), 404);

        return Storage::disk('public')->download($certification->file, $certification->downloadName());
    }
}
