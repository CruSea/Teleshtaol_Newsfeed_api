<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\User_log;
use App\NewsPost;
use App\NewsPostLike;
use App\NewsPostComment;

class DashboardController extends Controller
{
    public function getDailyMobileUserChartData($date_ref) {
        try{
            $cur_time = Carbon::now();
            $cur_time->subDay($date_ref);
            $mobile_User_data = array();
            $mobile_User_data['date'] = $cur_time->toDateString();
            $mobile_User_data['mobile_user_count'] = 0;
            $mobile_User_registered = User::where('user_type_id', 2 )->whereDate('created_at', '=', $cur_time->toDateString())->count();
            $mobile_User_logged_in = User_log::whereDate('last_login_at', '=', $cur_time->toDateString())->count();
            $mobile_User_data['mobile_user_registered_today'] = $mobile_User_registered ;
            $mobile_User_data['mobile_user_logged_in_today'] = $mobile_User_logged_in ;
            return response()->json(['status'=>true, 'mobile_user_chart_data'=> $mobile_User_data],200);
        }catch (\Exception $exception){
            return response()->json(['status'=>false, 'error'=> $exception->getMessage()],500);
        }
    }
    public function getWeeklyMobileUserChartData($date_ref){
        try{
            $cur_time = Carbon::now();
            $cur_time->subWeek(  $date_ref);
            $mobile_User_data = array();
            $mobile_User_data['date'] = $cur_time->toDateString();
            $mobile_User_data['weekly_created_users'] = User::where('user_type_id', 2 )->whereBetween('created_at', [$cur_time->copy()->startOfWeek(), $cur_time->copy()->endOfWeek()])->count();
            $mobile_User_data['weekly_logged_in__users'] = User_log::whereBetween('last_login_at', [$cur_time->copy()->startOfWeek(), $cur_time->copy()->endOfWeek()])->count();
//            $messageData['total_received'] = ReceivedMessage::whereIn('sent_from', Student::select('phone')->get())->whereBetween('created_at', [$cur_time->copy()->startOfWeek(), $cur_time->copy()->endOfWeek()])->count();
//            $messageData['gender_proportion'] = $this->getWeeklyGenderChartData($date_ref);
//            $messageData['location_proportion'] = $this->getWeeklyLocationsChartData($date_ref);
//            $messageData['student_year_proportion'] = $this->getWeeklyStudentYearChartData($date_ref);
            for($i = 0; $i <= 6; $i++) {
                $cur_time = $cur_time->copy()->startOfWeek();
                $sent_message_count = User::whereBetween('created_at', [$cur_time->copy()->startOfWeek(), $cur_time->copy()->endOfWeek()])->count();
//                $received_message_count = ReceivedMessage::whereBetween('created_at', [$cur_time->copy()->startOfWeek(), $cur_time->copy()->endOfWeek()])->count();
                $mobile_User_data['mobile_User_data_weekly'][] = $sent_message_count;
//                $messageData['received_messages'][] = $received_message_count;
//                $messageData['labels'][] = $cur_time->format('d/M/Y');
                $cur_time->subWeek(1);
            }
            return response()->json(['status'=>true, 'messages_chart_data'=> $mobile_User_data],200);
        }catch (\Exception $exception) {
            return response()->json(['status'=>false, 'error'=> $exception->getMessage()],500);
        }
    }
    public function getMainDashboardData() {
        try{
            $mainDashboard = array();
           // $mainDashboard['all_users'] = User::where('status', '=', true)->count();
            $mainDashboard['all_system_admin'] = User::where('user_type_id', '=', 1)->count();
            $mainDashboard['all_mobile_user'] = User::where('user_type_id', '=', 2)->count();
            $mainDashboard['all_system_users'] = User::count();
            return response()->json(['status'=> true,'message'=> 'Dashboard data fetched successfully', 'main_dashboard'=>$mainDashboard], 200);
        }catch (\Exception $exception){
            return response()->json(['status'=> false,'message'=> 'Whoops! failed to find news_feed_comments'], 500);
        }
    }
    
    

    
    public function getNewsPostDashboardData() {
        try{
            $feedsDashboard = array();
            $feedsDashboard['published_posts'] = NewsPost::where('approval', '=', true)->count();
            $feedsDashboard['not_published_posts'] = NewsPost::where('approval', '=', false)->count();
            $feedsDashboard['feeds_likes'] = NewsPostLike::count();
            $feedsDashboard['feeds_comments'] = NewsPostComment::count();
            return response()->json(['status'=> true,'message'=> 'Dashboard data fetched successfully', 'feeds_dashboard'=>$feedsDashboard], 200);
        }catch (\Exception $exception){
            return response()->json(['status'=> false,'message'=> 'Whoops! failed to find news_feed_comments'], 500);
        }
    }
    public function total(){
        $system_users = User::where('user_type_id', '=', 1)->count();
        $mobiel_user = User::where('user_type_id', '=', 2)->count();
        $users = User::all()->count();
        return response()->json([
            'users' => $users,
            'mobile_user' => $mobiel_user,
            'system_user' => $system_users
        ]);
    }
}
