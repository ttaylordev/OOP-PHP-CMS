<?php

class Post {

}

abstract class PostState {
    public int $post_id;
    public string $post_status;
    public string $post_category;
    public string $post_title;
    public string $post_author;
    public string $post_user;
    public function post_date(){
        $post_date = date('m/d/Y h:i:s a', time());
    }
    public string $post_image;
    public string $post_content;
    public array $post_tags;
    public int $postComment_count;
    public int $postViews_count;
    public int $postExposed_count;
}