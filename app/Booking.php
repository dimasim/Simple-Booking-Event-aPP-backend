<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model

{
    protected $fillable = [
        'user_id', 'event_id','quantity','status', 'total_price',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    // $table->bigIncrements('id');
    //         $table->unsignedBigInteger('user_id');
    //         $table->unsignedBigInteger('event_id');
    //         $table->integer('quantity')->default(1);
    //         $table->decimal('total_price', 10, 2)->default(0.00);
    //         $table->string('status')->default('pending'); // e.g., pending, confirmed
    //         $table->timestamps();

    //         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    //         $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            // $table->foreignId('event_id')->constrained()->onDelete('
}
