<?php

require('../../config.php');

require_login();
$context = context_system::instance();
$PAGE->set_context($context);

if ($bookmarkurl = htmlspecialchars_decode($_GET["bookmarkurl"]) and $title = $_GET["title"] and confirm_sesskey()) {

    /**
     * This gets the user_bookmarks
     */
    if (get_user_preferences('user_bookmarks')) {
        $bookmarks = explode(',', get_user_preferences('user_bookmarks'));
        
        if (in_array(($bookmarkurl . "|" . $title), $bookmarks)) {
            print_error('bookmarkalreadyexists','admin');
            die;
        }

    } else {
        $bookmarks = array();
    }

    //adds the bookmark at end of array
    $bookmarks[] = $bookmarkurl . "|" . $title;
    $bookmarks = implode(',', $bookmarks);
    
    //adds to preferences table
    set_user_preference('user_bookmarks', $bookmarks);
    
    global $CFG;
    header("Location: " . $CFG->wwwroot . $bookmarkurl);
} else {
    print_error('invalidsection','admin');
    die;
}

