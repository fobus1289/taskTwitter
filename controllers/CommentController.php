<?php

namespace app\controllers;

use request\create\CommentCreateRequest;
use request\update\CommentUpdateRequest;
use app\models\Comment;

class CommentController extends BaseRestController
{
 
    protected $authoBindingParams = true;
    
    protected function postConstruct()
    {
        $this->middleware(['cross'],'*');
        $this->middleware(['me'])
                ->only(['actionCreate','actionUpdate','actionDelete']);
    }
    
    public function actionCreate(CommentCreateRequest $request)
    {
        
        if($request->file('media')) {
           $request->media = $request->store('media');
        }
        
        $comment = user()->attachComment($request->all());
        
        return $this->asJson([
            'success'=> (bool)$comment,
        ]);
        
    }
   
        
    public function actionComments()
    {
        $models = Comment::find()
                ->where(['user_id' => post('id')])
                ->all();
        return $this->asJson([
            'models' =>  map($models, function($key,$value){
                            return $value->fields();
                         }),
        ]);
    }


    public function actionUpdate(CommentUpdateRequest $request)
    {
        
        $comment = user()->findByIdComment($request->id);
                  
        filter($request->all(), function($key,$value) use($comment){
            if($comment->hasAttribute($key)) {
                $comment->$key = $value;
            }
        });

        if($request->file('media')) {
            @\unlink(base_path($comment->media));
            $comment->media = $request->store('media');
        }
            
        $update = $comment->save();
             
        return $this->asJson([
            'success'=> (bool)$update,
            'comment'=> $comment
        ]);
        
    }
    
    public function actionDelete($id)
    {
        $user = user();
        $comment = $user->findByIdComment($id);

        $delete = $comment->delete();
            
        if(is_numeric($delete) && $delete !== 0) {

            $child = $comment->child();

            filter($child, function($key,$model){
                $model->parent_id = -1;
                $model->save();
            });

        }
            
        @\unlink(base_path($comment->media));
        
        
        return $this->asJson([
            'success' => (bool)$delete
        ]);
        
    }
        
}
