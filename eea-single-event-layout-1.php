<?php

/*
  Plugin Name:      Event Espresso - Event Content Display 1
  Plugin URI:       http://eventespresso.com
  Description:      Alters the order of single event details to display the description -> datetimes -> ticket selector -> venue details
  Version:          1.0.0
  Author:           Seth Shoultes
  Author URI:       http://eventespresso.com
  License:          GPL 2.0
  Copyright           (c) 2008-2015 Event Espresso  All Rights Reserved.
  */

add_filter('the_content', 'event_content_display_1', 100);
// move stuff around
function event_content_display_1($content)
{
    if ('espresso_events' == get_post_type() && is_singular() && !post_password_required()) {
        remove_filter('the_content', array( 'EED_Event_Single', 'event_datetimes' ), 110);
        remove_filter('the_content', array( 'EED_Event_Single', 'event_tickets' ), 120);
        remove_filter('the_content', array( 'EED_Event_Single', 'event_venues' ), 130);
        add_filter('the_content', 'event_content_display_1_datetimes', 132);
        add_filter('the_content', 'event_content_display_1_tickets', 134);
        add_filter('the_content', 'event_content_display_1_venues', 136);
    }
    return $content;
}
// add datetimes after the description
function event_content_display_1_datetimes($content)
{
    return EEH_Template::locate_template('content-espresso_events-datetimes.php') . $content;
}
// add venues after the description
function event_content_display_1_venues($content)
{
    return $content . EEH_Template::locate_template('content-espresso_events-venues.php');
}
// add tickets after the datetimes
function event_content_display_1_tickets($content)
{
    return $content . EEH_Template::locate_template('content-espresso_events-tickets.php');
}
