<?php

namespace App\Http\Forms;

use App\Models\Reply;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::denies('create', Reply::class);
        // return true;
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException('You are replying too frequently. Please, take a break');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }
    
    public function persist($thread)
    {
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
            'thread_id' => $thread->id,
        ]);
    }
}
