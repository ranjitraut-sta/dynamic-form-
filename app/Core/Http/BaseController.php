<?php

namespace App\Core\Http;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    public function __construct()
    {
        // $this->middleware('check.permission');
    }

    protected function redirectWithSuccess(string $route, string $message)
    {
        return redirect()->route($route)->with('success', $message);
    }

    protected function redirectBackWithSuccess(string $message)
    {
        return redirect()->back()->with('success', $message);
    }


    protected function redirectWithError(string $route, string $message)
    {
        return redirect()->route($route)->with('error', $message);
    }


    protected function redirectBackWithErrorMessage(string $message)
    {
        return redirect()->back()->with('error', $message);
    }

    protected function prepareCommonData(string $headerTitle): array
    {
        return [
            'header_title' => $headerTitle,
        ];
    }

    protected function makeDto(string $dtoClass, array $data): mixed
    {
        return $dtoClass::fromArray($data);
    }




}
