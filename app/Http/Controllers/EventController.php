<?php

namespace EventManagementSystem\App\Http\Controllers;

use Exception;
use EventManagementSystem\Framework\Request\Request;
use EventManagementSystem\App\Http\Requests\EventRequest;
// use EventManagementSystem\App\Http\Traits\ValidatorTrait;

class EventController extends Controller
{
    // use ValidatorTrait;
    public function index(Request $request)
    {
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
        $value = [
            "title"         => 'sanitize_text_field',
            "onlineEvent"   => 'sanitize_text_field',
            "details"       => 'sanitize_textarea_field',
            // "category"      => 'sanitize_text_field',
            // "organizer"     => 'sanitize_text_field',
            'limit'         => 'sanitize_text_field',
            "startingDate"  => 'sanitize_text_field',
            "startingTime"  => 'sanitize_text_field',
            "endingDate"    => 'sanitize_text_field',
            "endingTime"    => 'sanitize_text_field',
            "location"      => 'sanitize_text_field',
            "deadline"      => 'sanitize_text_field'
        ];

        foreach ($value as $key => $sanitizer) {
            $data[$key] = $request->getSafe($key, $sanitizer);
        }
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

    public function updateEventData(Request $request)
    {
        // dd($request->only(['id']));

        $id = $request->only(['id']);

        $value = [
            "title"         => 'sanitize_text_field',
            "onlineEvent"   => 'sanitize_text_field',
            "details"       => 'sanitize_textarea_field',
            // "category"      => 'sanitize_text_field',
            // "organizer"     => 'sanitize_text_field',
            'limit'         => 'sanitize_text_field',
            "startingDate"  => 'sanitize_text_field',
            "startingTime"  => 'sanitize_text_field',
            "endingDate"    => 'sanitize_text_field',
            "endingTime"    => 'sanitize_text_field',
            "location"      => 'sanitize_text_field',
            "deadline"      => 'sanitize_text_field'
        ];

        foreach ($value as $key => $sanitizer) {
            $eventData[$key] = $request->getSafe($key, $sanitizer);
        }


        // $eventData['title'] = $request->getSafe("title", 'sanitize_text_field');
        // $eventData['details'] = $request->getSafe("details", 'sanitize_textarea_field');
        // $eventData['onlineEvent'] = $request->getSafe("onlineEvent", 'sanitize_text_field');
        // $eventData['category'] = $request->getSafe("category", 'sanitize_text_field');
        // $eventData['organizer'] = $request->getSafe("organizer", 'sanitize_text_field');
        // $eventData['limit'] = $request->getSafe("limit", 'sanitize_text_field');
        // $eventData['startingDate'] = $request->getSafe("startingDate", 'sanitize_text_field');
        // $eventData['startingTime'] = $request->getSafe("startingTime", 'sanitize_text_field');
        // $eventData['endingDate'] = $request->getSafe("endingDate", 'sanitize_text_field');
        // $eventData['endingTime'] = $request->getSafe("endingTime", 'sanitize_text_field');
        // $eventData['location'] = $request->getSafe("location", 'sanitize_text_field');
        // $eventData['deadline'] = $request->getSafe("deadline", 'sanitize_text_field');

        // dd($data);


        // var_dump($eventData['image']);
        // $categoryId = (int)$eventData['category'];
        // $term = get_term($eventData['category']);
        // $eventData["category"] = $term->name;
        // $eventData["categoryID"] = $categoryId;
        $postContent = json_encode($eventData);

        // dd($id['id']);
        // extract($eventData); //Extract $id, $title , $postContent, $metaArray
        $metaArray = array(
            'eventData' =>  $postContent,
        );
        $data = array(
            'ID' => $id['id'],
            'post_title' =>  $eventData['title'],
            'meta_input' => $metaArray,
        );

        $eventId =  wp_update_post($data, true);
        if (is_wp_error($eventId)) {
            return
                [
                    "error" => __("Error while updating data", "event-management-system"),
                ];
        }

        // wp_set_object_terms($eventId, [$categoryId], 'eventCategory');

        return
            [
                "message" => __("Successfully updated Data", "event-management-system"),
            ];
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
