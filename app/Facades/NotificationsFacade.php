<?php

namespace App\Facades;
use App\Notifications;
use Auth;

class NotificationsFacade {
	public function create($data) {
		if(!is_array($data)) {
			return abort(404);
		}
		$create = Notifications::create($data);
		return $create;
	}

	public function me() {
		$notifications = Notifications::whereTo(Auth::user()->id)->orWhere('to', NULL)->paginate(config('starter.pagination'));
		return $notifications;
	}

	public function unread() {
		$notifications = Notifications::whereTo(Auth::user()->id)->orWhere('to', NULL)->where(function($query) {
			$query->whereStatus('unread');
		})->limit(10)->get();
		return $notifications;
	}

	public function count() {
		$notifications = Notifications::whereStatus('unread')->where(function($query) {
			$query->whereTo(Auth::user()->id);
			$query->orWhere('to', NULL);
		})->count();
		return $notifications;
	}

	public function read() {
		$notifications = Notifications::whereTo(Auth::user()->id)->update(['status' => 'read']);
		return $notifications;
	}

	public function all() {
		$notifications = Notifications::whereTo(Auth::user()->id)->orWhere('to', null)->limit(10)->get();
		return $notifications;
	}
}