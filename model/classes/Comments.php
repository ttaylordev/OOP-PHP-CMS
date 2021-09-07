<?php

class Comment {
    public int $comment_id;
    public string $comment_category;
    public string $comment_author;
    public array $comment_image;
    public string $comment_content;
    public string $comment_user;
    public int $comment_parent; //id of parent comment

}

abstract class CommentState {
    public string $comment_status;
    public function comment_date(){
        $comment_date = date('m/d/Y h:i:s a', time());
    }
    public int $commentComment_count;
}