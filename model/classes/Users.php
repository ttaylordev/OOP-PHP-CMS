<?php

class User {
    public $user_id;
    public $user_messages;
    public $user_title;
}

abstract class UserProfile {
    public $user_company;
    public $user_website;
    public $user_city;
    public $user_country;
    public $user_id;
    public $user_name;
    public $user_firstName;
    public $user_lastName;
    public $user_password;
    public $user_email;
    public $user_image;
    public $user_role;
}

abstract class UserState {
    
    public $user_auth_status;
    
}

abstract class UserSettings {
    public $user_notifications_bool;
    public $user_session_limit;
    
}

abstract class UserHistory {
    public $user_verified_bool;
    public $user_password_age;
    public $user_last_logon;
    public $user_status;
    public function user_joinDate(){
        $$user_joinDate = date('m/d/Y h:i:s a', time());
    }
    public $user_lastPostDate;
    public $user_post_count;
    public $user_comment_count;
    public $user_views_count;
}

class Admin {
    
    // admin is

    // admin does

}

class Subscriber {

    // subscriber is

    // subscriber does
}

class Author {

    // author is

    // author does

}



// separate user handling(session) from the database query

// properties and methods should have equivalent visibility

