<?php
namespace App\Notifications;

use App\Models\Producto;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StockBajoNotification extends Notification
{
    protected $producto;
    protected $mensaje;

    public function __construct(Producto $producto, $mensaje)
    {
        $this->producto = $producto;
        $this->mensaje = $mensaje;
    }

    public function via($notifiable)
    {
        return ['mail']; // Enviar por correo electrónico
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Alerta de Stock Bajo')
                    ->line($this->mensaje)
                    ->action('Ver Producto', route('productos.show', $this->producto->id))
                    ->line('Gracias por usar nuestra aplicación!');
    }
}
