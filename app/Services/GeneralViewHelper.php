<?php

namespace App\Services;

use App\ForumTopic;
use App\Services\Forum\TopicService;
use App\Traits\ViewHelper\ForumData;


class GeneralViewHelper
{
    use ForumData;

    protected $last_forum;
    protected $last_forum_home;
    protected $all_sections;
    protected $section_icons;
    protected static $instance;

    public function __construct()
    {
        if (!self::$instance) {
            self::$instance = $this;
        }
    }

    /**
     * @param ForumTopic $topic
     * @return bool
     */
    public function checkForumEdit(ForumTopic $topic)
    {
        return TopicService::checkForumEdit($topic);
    }

}