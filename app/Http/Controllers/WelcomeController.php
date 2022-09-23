<?php

namespace EventManagementSystem\App\Http\Controllers;

use Exception;
use EventManagementSystem\Framework\Request\Request;
use EventManagementSystem\App\Http\Requests\EventRequest;
// use EventManagementSystem\App\Http\Traits\ValidatorTrait;

class WelcomeController extends Controller
{
    // use ValidatorTrait;
    public function index(Request $request)
    {
        // return [
        //     'message' => 'Welcome to WPFluent.'
        // ];
        // return Bike::get();

        $args = array(
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'ASC',
            'post_type' => 'ems_event_data',
            'post_status' => 'publish',
        );
        return get_posts($args);
    }

    public function inputform(Request $request)
    {
        $rules = EventRequest::$rules;
        $messages = EventRequest::$messages;
        // $this->validateData($request->all(), $rules, $messages);
        $this->validate($request->all(), $rules, $messages);

        // dd(sanitize_text_field($request->title));
        // $request->title =  $request->getSafe('title', 'sanitize_text_field');

        $data['title'] = $request->getSafe("title", 'sanitize_text_field');
        $data['details'] = $request->getSafe("details", 'sanitize_textarea_field');
        $data['onlineEvent'] = $request->getSafe("onlineEvent", 'sanitize_text_field');
        $data['category'] = $request->getSafe("category", 'sanitize_text_field');
        $data['organizer'] = $request->getSafe("organizer", 'sanitize_text_field');
        $data['limit'] = $request->getSafe("limit", 'sanitize_text_field');
        $data['startingDate'] = $request->getSafe("startingDate", 'sanitize_text_field');
        $data['startingTime'] = $request->getSafe("startingTime", 'sanitize_text_field');
        $data['endingDate'] = $request->getSafe("endingDate", 'sanitize_text_field');
        $data['endingTime'] = $request->getSafe("endingTime", 'sanitize_text_field');
        $data['location'] = $request->getSafe("location", 'sanitize_text_field');
        $data['deadline'] = $request->getSafe("deadline", 'sanitize_text_field');

        $finalData = json_encode($data);
        $metaArray = array(
            "eventData" =>  $finalData,
        );

        $data = array(
            'post_title'    => $data['title'],
            'post_type'     =>  'ems_event_data',
            'meta_input'    =>  $metaArray,
            'post_status'   =>  'publish',
        );
        $eventId =  wp_insert_post($data, true);
        if (is_wp_error($eventId)) {
            return wp_send_json_error(
                [
                    "error" => __("Error while inserting data", " event-management-system"),
                ],
                500
            );
        }
        wp_set_object_terms($eventId, [$categoryId], 'eventCategory');
        return wp_send_json_success(
            [
                "message" => __("Successfully inserted data", " event-management-system"),
            ],
            200
        );
        // dd($data);
        // var_dump($request->title);
        // var_dump($request->all());

        // return Bike::create($request->all());
        // return [
        //     'data' => $request->all()
        // ];
    }

    public function eventData()
    {
        $args = array(
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'ASC',
            'post_type' => 'ems_event_data',
            'post_status' => 'publish',
        );
        $data = get_posts($args);

        // dd($data);
        if ($data) {
            return ['event_data'     => $data];
        }
    }

    public function singleEventData($id)
    {
        // dd($id);
        $singleEvent = get_post_meta($id, '', true);
        if (!$singleEvent) {

            return ([
                "error" => __("Error while fetching data", " event-management-system"),
            ]
            );
        }
        return ([
            'single_event_data'     => $singleEvent,
        ]
        );
    }

    public function deleteEventData(Request $request)
    {
        // dd($request->id);
        try {
            // $delete = wp_delete_post($request->id);
            $delete = wp_delete_post($request->getSafe('id', '', 'intval'));
            if ($delete) {
                return [
                    'status' => 200,
                    'message' => __('Event has been deleted'),
                ];
            }
            return [
                'status' => 500,
                'error' => __('Something Error happened'),
            ];
        } catch (Exception $ex) {
            return [
                'status' => 500,
                'message' => __($ex->message),
            ];
        }
    }
}
