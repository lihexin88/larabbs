<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\TopicTransformer;
use App\Http\Requests\Api\TopicRequest;
use Illuminate\Support\Facades\DB;


class TopicsController extends Controller
{
    /**
     * 新建话题 api
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Dingo\Api\Http\Response
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();

        return $this->response->item($topic, new TopicTransformer())->setStatusCode(201);
    }

    /**
     * 修改话题
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->update($request->all());
        return $this->response->item($topic, new TopicTransformer());
    }


    /**
     *
     * 删除话题
     * @param Topic $topic
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $topic->delete();
        return $this->response->noContent();
    }
}
