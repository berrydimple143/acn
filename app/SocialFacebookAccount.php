<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model; 

class SocialFacebookAccount extends Model {
  protected $table = 'social_media';
  public $timestamps = false;
  protected $fillable = ['user_id', 'provider_user_id', 'provider', 'created_at', 'updated_at'];
  
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
