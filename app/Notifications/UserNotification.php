<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class UserNotification extends Notification
{
    protected string $title;
    protected string $message;
    protected string $link;
    protected string $module;
    protected string $module_id;
    protected string $messageKey;
    protected array $messageParams;
    protected string $type;
    
    public function __construct(string $title, string $messageKey, array $messageParams, string $link, string $module, string $module_id, string $type)
    {
        $this->title = $title;
        $this->messageKey = $messageKey; 
        $this->messageParams = $messageParams;  
        $this->link = $link;
        $this->module = $module;
        $this->module_id = $module_id;
        $this->type = $type;
    }

    // Notificación en base de datos
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'messageKey' => $this->messageKey,
            'messageParams' => $this->messageParams,
            'url' => $this->link,  
            'module' => $this->module,
            'module_id' => $this->module_id,
            'type' => $this->type,
        ];
    }

    // Notificación en tiempo real con WebSockets
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title, 
            'messageKey' => $this->messageKey,
            'messageParams' => $this->messageParams,
            'url' => $this->link, // Usa el link personalizado
            'module' => $this->module,
            'module_id' => $this->module_id,
            'type' => $this->type,
        ]);
    }

    // Notificación en array (para facilitar almacenamiento y uso)
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title, 
            'messageKey' => $this->messageKey,
            'messageParams' => $this->messageParams,
            'url' => $this->link,
            'module' => $this->module,
            'module_id' => $this->module_id,
            'type' => $this->type,
        ];
    }

    public function via($notifiable)
    {
        return ['database']; // Evita correos no deseados
    } 
}
