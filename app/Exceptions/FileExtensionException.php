<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileExtensionException extends Exception
{

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report(): ?bool
    {
        // Determine if the exception needs custom reporting...

        return true;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function render(Request $request)
    {
        $toastType = "error";
        $toastTitle = "Error";
        $toastDescription = "Impossible to find what is your image";
        $toastDuration = 5000;

        return Redirect::back()->withInput()->with('toast',
            createToast($toastType, $toastTitle, $toastDescription, $toastDuration));
    }

}
