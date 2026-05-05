<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Admission extends Model {
    protected $fillable = ['applicant_name','dob','parent_name','email','phone','class_applying','message','extra_data','status','admin_notes','submitted_at'];
    protected $casts = ['dob' => 'date', 'submitted_at' => 'datetime', 'extra_data' => 'array'];
    public function scopeNew($q) { return $q->where('status', 'new'); }
    public function getStatusColorAttribute(): string {
        return match($this->status) { 'new' => 'blue', 'reviewed' => 'yellow', 'accepted' => 'green', 'rejected' => 'red', default => 'gray' };
    }
}
