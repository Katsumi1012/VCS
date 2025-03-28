<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    public function index(){
        $homeworklist=DB::table('baitap')->get();
        return view('backend.homework.index',compact('homeworklist'));
    }
    public function studentindex(){
        $homeworklist=DB::table('baitap')->get();
        return view('backend.homework.studentindex',compact('homeworklist'));
    }
    public function addForm(){
        return view('backend.homework.add');
    }
    public function add(Request $request){
        if ($request->hasFile('homeworkfile')){
            $filename=$request->homeworkfile->getClientOriginalName();
            DB::table('baitap')->insert([
                'filename' => $filename,
            ]);
            $request->homeworkfile->move(public_path('homeworkfolder'),$filename);
        }
        return view('backend.homework.add');
    }

    public function addSolutionForm($tid){
        return view('backend.homework.addsolution',['tid'=>$tid]);
    }
    public function addSolution(Request $request, $tid, $sid){
        if ($request->hasFile('solutionfile')){
            $filename=$request->solutionfile->getClientOriginalName();
            $solution = DB::table('bailam')->where('task_id',$tid)
                                           ->where('student_id',$sid)->first();
            if ($solution===null){
                DB::table('bailam')->insert([
                    'task_id'    => $tid,
                    'student_id' => $sid,
                    'filename'   => $filename,
                ]);
            }else{
                $oldfile= public_path() . '/solutionfolder/' . $solution->filename;
                if (is_file($oldfile) && file_exists($oldfile)) {
                    unlink($oldfile);
                }
                DB::table('bailam')->where('task_id',$tid)
                                   ->where('student_id',$sid)
                                   ->update(['filename' => $filename]);
            }
            $request->solutionfile->move(public_path('solutionfolder'),$filename);
        }
        return redirect()->route('homework.studentindex');
    }

    public function solutionlist($tid){
        $result = DB::table('baitap')
                                ->select('baitap.task_id','bailam.filename','users.*')
                                ->join('bailam',function($join) use ($tid){
                                    $join->on('baitap.task_id','=','bailam.task_id')->where('baitap.task_id','=',$tid);
                                })->join('users','users.id','=','bailam.student_id')->get();
        return view('backend.homework.solutionlist',compact('result'));
    }
    public function download($filename){
        $path=public_path('homeworkfolder/'.$filename);
        if(file_exists($path)){
            return response()->download($path);
        }
        return "File khong ton tai";
    }
    public function downloadSolution($filename){
        $path=public_path('solutionfolder/'.$filename);
        if(file_exists($path)){
            return response()->download($path);
        }
        return "File khong ton tai";
    }
}
