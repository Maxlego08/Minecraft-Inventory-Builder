<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserFileFullException extends Exception
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
        $toastTitle = "Impossible to create an image";
        $toastDescription = "You dont have enough space for upload a new image.";
        $toastDuration = 5000;

        return Redirect::back()->withInput()->with('toast',
            createToast($toastType, $toastTitle, $toastDescription, $toastDuration));
    }
}
