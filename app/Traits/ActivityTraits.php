<?php
namespace App\Traits;
use App\Model\Activity;
use carbon\carbon;

trait ActivityTraits
{
	
	public function logCreatedActivity($logModel, $changes, $request ) {

		$activity = activity()
			->causedBy(\Auth::user())
			->performedOn($logModel)
			->withProperties(['attributes'=> $request])
			->log($changes);
		$lastActivity = Activity::all()->last();

		return true;
	}


	public function logUpdatedActivity($list, $before, $list_changes) {
	    unset($list_changes['updated_at']);

       $old_keys = [];

       $old_value_array = [];
       if(empty($list_changes)){
           $changes = 'No attribute changed';
           
       }else{
           
           if(count($before)>0){
               
               foreach($before as $key=>$original){
                   if(array_key_exists($key,$list_changes)){
                       
                       $old_keys[$key]=$original;
                   }
               }
           }
           $old_value_array = $old_keys;
           $changes = 'Updated with attributes '.implode(', ',array_keys($old_keys)).' with '.implode(', ',array_values($old_keys)).' to '.implode(', ',array_values($list_changes));
       }
       
       $properties = [
           'attributes'=>$list_changes,
           'old' =>$old_value_array
       ];
       
       $activity = activity()
           ->causedBy(\Auth::user())
           ->performedOn($list)
           ->withProperties($properties)
           ->log($changes.' made by '.\Auth::user()->name);
       return true;
	}

	public function unsetAttributes($model) {
		unset($model->created_at);
		unset($model->updated_at);
		return $model
	}

	 public function logLoginDetails($user)
   {
       $updated_at = Carbon::now()->format('d/m/Y H:i:s');
       $properties = [
           'attributes' =>['name'=>$user->username,'description'=>'Login into the system by '.$updated_at]
       ];
 
       $changes = 'User '.$user->username.' loged in into the system';
 
       $activity = activity()
           ->causedBy(\Auth::user())
           ->performedOn($user)
           ->withProperties($properties)
           ->log($changes);
 
       return true;
   }

}