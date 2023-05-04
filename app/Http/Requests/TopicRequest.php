<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    // CREATE ROLES
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'       => 'required|min:2',
                    'content'        => 'required|min:3|max:1024',
                    'category_id' => 'required|numeric',
                   ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            }
        }
    }

    public function messages()
    {
         return [
            'title.min' => '标题必须至少两个字符',
            'content.min' => '文章内容必须至少三个字符',
            // 'content.mimes' =>'上传文件必须是 png, jpg, gif, jpeg 的格式',
            'content.max' =>'上传的文件大小不超过1024KB',
        ];
    }
}
