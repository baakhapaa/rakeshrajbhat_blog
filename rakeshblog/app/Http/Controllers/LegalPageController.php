<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Carbon;

class LegalPageController extends Controller
{
    public function privacy()
    {
        return $this->show('privacy');
    }

    public function terms()
    {
        return $this->show('terms');
    }

    private function show(string $page)
    {
        $legal = Setting::getLegalPage($page);
        $updatedLabel = Carbon::parse($legal['updated_on'])->format('F j, Y');

        return view('legal.page', [
            'legal' => $legal,
            'updatedLabel' => $updatedLabel,
        ]);
    }
}
