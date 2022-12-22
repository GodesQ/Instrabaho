<?php

namespace App\Actions;

// use App\Http\Requests\StoreNotification;
use App\Models\Notification;
use App\Models\NotificationChange;
use App\Models\NotificationObject;
use App\Models\EntityType;

class StoreNotificationAction {

    public function createNotification($object = null, $entity = null) {
        if(!$object && $entity) return;

        $entity_type = EntityType::where('slug', $entity)->first();

        $notification_message = $entity_type->notification_message;
        $notification_message = str_replace("{{user}}", $object->freelancer->display_name, $notification_message);
        $notification_message = str_replace("{{project}}", $object->project->title, $notification_message);

        # third create notification
        $notification = Notification::create([
            'notifier_id' => $object->employer->id,
            'actor_id' => $object->freelancer->id,
            'notification_message' => $notification_message,
            'notifier_role' => 'employer',
            'actor_role' => 'freelancer',
            'entity_type_id' => $entity_type->id,
            'status' => false
        ]);

        return $notification;
    }
}
