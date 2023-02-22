<?php

namespace Modules\Base\Traits;

use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

trait ApiResponse
{
    protected function success($data = null, $message = '')
    {
        return response()->success(data: $data, message: $message);
    }

    protected function error($message = '', $errors = [])
    {
        return response()->error(message: $message, errors: $errors);
    }

    protected function created($model)
    {
        $modelName = $this->getModelName($model);
        return $this->success(message: __('messages.success.created', ['model' => $modelName]));
    }

    protected function updated($model)
    {
        $modelName = $this->getModelName($model);
        return $this->success(message: __('messages.success.updated', ['model' => $modelName]));
    }

    protected function deleted($model)
    {
        $modelName = $this->getModelName($model);
        return $this->success(message: __('messages.success.deleted', ['model' => $modelName]));
    }

    protected function noContent()
    {
        return response()->success(status: Response::HTTP_NO_CONTENT);
    }

    public function getModelName($model): ?string
    {
        try {
            return $this->modelDisplayName ?? (new ReflectionClass($model))->getShortName();
        } catch (\ReflectionException $e) {
            Log::error($e);
            return '';
        }
    }
}
