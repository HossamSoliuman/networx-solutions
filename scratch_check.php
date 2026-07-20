$rows = App\Models\Setting::whereIn("key", ["home_title","home_eyebrow","home_intro"])->pluck("value","key");
echo $rows->toJson();
