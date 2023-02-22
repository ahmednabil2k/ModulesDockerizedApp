<?php

namespace Modules\Base\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class ApiResponseProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Handles success response
        response()->macro('success', function ($data = null, $message = '', $status = 200) {
            return response()->json([
                'success'  => true,
                'message'  => $message ?? '',
                'data'     => $data ?? (object)[],
                'meta'     => ApiResponseProvider::getMetaData($data),
            ], $status)->withHeaders([
                'Content-Type' => 'application/json',
            ]);
        });

        // Handles normal failed response
        response()->macro('error', function ($errors, $message = '' , $status = 400) {
            $errors = is_string($errors) ?
                [ ['key' => 'Custom Error', 'error' => $errors] ]
                : $errors;

            return response()->json([
                'success'  => false,
                'message'  => $message ?: $errors[0]['error'] ?? '',
                'data'     => (object)[],
                'errors'   => $errors ?? (object)[],
            ], $status)->withHeaders([
                'Content-Type' => 'application/json',
            ]);
        });

        // Handles validation errors response
        response()->macro('validationError', function ($errors = []) {
            $errorMessages = [];

            foreach ($errors as $key => $fieldErrors) {
                foreach ($fieldErrors as  $error) {
                    $error = (isset($error) && is_array($error)) ? $error[0] : $error;

                    $errorMessages[] = [
                        'key'    => $key,
                        'error'  => $error
                    ];
                }
            }

            return response()->error(
                errors: $errorMessages,
                status: 422
            );
        });
    }

    public static function getMetaData($data): array|object
    {
        if (isset($data->resource) && $data->resource instanceof Paginator) {
            $response = $data->toResponse(request())->getData();
            return [
                'links'      => $response->links,
                'pagination' => $response->meta
            ];
        }
        return (object)[];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
