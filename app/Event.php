<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'name','user_id' ,'date', 'location', 'description',
        'start_time', 'end_time', 'price', 'total_ticket', 'image'
        // $table->bigIncrements('id');
        //     $table->unsignedBigInteger('user_id');
        //     $table->string('name');
        //     $table->text('description')->nullable();
        //     $table->string('location');
        //     $table->dateTime('start_time');
        //     $table->dateTime('end_time');
        //     $table->decimal('price', 10, 2)->default(0.00);
        //     $table->integer('total_ticket')->default(0);
        //     $table->string('image')->nullable();
        //     $table->timestamps();
 
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
