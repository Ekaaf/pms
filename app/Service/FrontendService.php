<?php

namespace App\Service;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateEmployment;
use App\Models\Masterconfig;
use App\Models\CandidateReference;
use App\Models\Job;

class FrontendService{

    public function generateRandomToken($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $length = 10;
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString .= strtotime(now());
        return bin2hex(base64_encode($randomString));
    }


    public function saveCandidate($dbPath, $folder, $request){
        $candidate = Candidate::where('user_id', Auth::user()->id)->first();
        if(is_null($candidate)){
            $candidate = new Candidate();
        }

        $candidate->user_id = Auth::user()->id;
        $candidate->full_name = $request->full_name;
        $candidate->email = Auth::user()->email;
        $candidate->father_name = $request->father_name;
        $candidate->mother_name = $request->mother_name;
        $candidate->marrital_status = $request->marrital_status;
        $candidate->gender = $request->gender;
        $candidate->religion = $request->religion;
        $candidate->nationality = $request->nationality;
        $candidate->mobile = $request->mobile;
        $candidate->emergency_contact = $request->emergency_contact;
        $candidate->permanent_address = $request->permanent_address;
        $candidate->present_address = $request->present_address;
        $candidate->dob = $request->dob;
        $candidate->blood_group = $request->blood_group;
        if($request->identification == 'NID'){
            $candidate->nid = $request->nid;
            if($request->nid_photo != 'undefined'){
                $nid_photo_filename = 'nid_photo_'.date("Y_m_d_H_i_s").'.'.$request->file('nid_photo')->getClientOriginalExtension();
                $candidate->nid_photo = $dbPath.'/'.$nid_photo_filename;
                $request->file('nid_photo')->move($folder,$nid_photo_filename);
            }
            $candidate->passport = NULL;
            $candidate->passport_photo = NULL;
            $candidate->birthcirtificate = NULL;
            $candidate->birthcirtificate_photo = NULL;
        }
        elseif($request->identification == 'Passport'){
            $candidate->passport = $request->nid;
            if($request->nid_photo != 'undefined'){
                $nid_photo_filename = 'passport_photo_'.date("Y_m_d_H_i_s").'.'.$request->file('nid_photo')->getClientOriginalExtension();
                $candidate->passport_photo = $dbPath.'/'.$nid_photo_filename;
                $request->file('nid_photo')->move($folder,$nid_photo_filename);
            }
            $candidate->nid = NULL;
            $candidate->nid_photo = NULL;
            $candidate->birthcirtificate = NULL;
            $candidate->birthcirtificate_photo = NULL;
        }
        else{
            $candidate->birthcirtificate = $request->nid;
            if($request->nid_photo  != 'undefined'){
                $nid_photo_filename = 'birthcirtificate_photo_'.date("Y_m_d_H_i_s").'.'.$request->file('nid_photo')->getClientOriginalExtension();
                $candidate->birthcirtificate_photo = $dbPath.'/'.$nid_photo_filename;
                $request->file('nid_photo')->move($folder,$nid_photo_filename);
            }
            $candidate->nid = NULL;
            $candidate->nid_photo = NULL;
            $candidate->passport = NULL;
            $candidate->passport_photo = NULL;
        }
        
        if($request->photo != 'undefined'){
            $photo_filename = 'photo_'.date("Y_m_d_H_i_s").'.'.$request->file('photo')->getClientOriginalExtension();
            $candidate->photo = $dbPath.'/'.$photo_filename;
            $request->file('photo')->move($folder,$photo_filename);
        }
        
        if($request->signature != 'undefined'){
            $signature_filename = 'signature_'.date("Y_m_d_H_i_s").'.'.$request->file('signature')->getClientOriginalExtension();
            $candidate->signature = $dbPath.'/'.$signature_filename;
            $request->file('signature')->move($folder,$signature_filename);
        }
        
        $candidate->created_by = Auth::user()->id;
        // $candidate->language = implode(",", $request->language);
        $candidate->language = $request->language;
        if($request->cv != 'undefined'){
            $cv_filename = 'cv_'.date("Y_m_d_H_i_s").'.'.$request->file('cv')->getClientOriginalExtension();
            $candidate->cv = $dbPath.'/'.$cv_filename;
            $request->file('cv')->move($folder,$cv_filename);
        }

        $candidate->save();
        return $candidate;
    }


    public function saveCandidateEducation($dbPath, $folder, $candidate_id, $i, $request){
        if(isset($request->candidate_edu_id[$i])){
            $candidate_education = CandidateEducation::where('id', $request->candidate_edu_id[$i])->where('candidate_id', $candidate_id)->first();
        }
        else{
            // CandidateEducation::where('id', $request->candidate_edu_id[$i])->where('candidate_id', $candidate_id)->delete();
            $candidate_education = new CandidateEducation();
        }
        // dd($candidate_education);
        $candidate_education->candidate_id = $candidate_id;
        $candidate_education->level_of_edu = $request->level_of_edu[$i];
        $candidate_education->degree_title = $request->degree_title[$i];
        $candidate_education->major = $request->major[$i];
        $candidate_education->institution_name = $request->institution_name[$i];
        $candidate_education->board_name = $request->board_name[$i];
        $candidate_education->result_type = $request->result_type[$i];
        $candidate_education->obtained_result = ($request->obtained_result[$i])??$request->marks[$i];
        $candidate_education->scale = $request->scale[$i];
        // $candidate_education->marks = $request->marks[$i];
        $candidate_education->year_of_passing = $request->year_of_passing[$i];
        $candidate_education->duration = $request->duration[$i];
        $candidate_education->achievement = $request->achievement[$i];
        if(isset($request->file('certificate')[$i]) && $request->file('certificate')[$i] != 'undefined'){
            $certificate_filename = 'certificate_'.$i.'_'.date("Y_m_d_H_i_s").'.'.$request->file('certificate')[$i]->getClientOriginalExtension();
            $candidate_education->certificate = $dbPath.'/'.$certificate_filename;
            $request->file('certificate')[$i]->move($folder,$certificate_filename);
        }
        $candidate_education->created_by = Auth::user()->id;

        // dd($candidate_education);
        $candidate_education->save();

        
        return $candidate_education->id;
    }


    public function saveCandidateEmployment($dbPath, $folder, $candidate_id, $j, $request){
        $candidate_employment = new CandidateEmployment();

        $candidate_employment->candidate_id = $candidate_id;
        $candidate_employment->company = $request->company[$j];
        $candidate_employment->designation = $request->designation[$j];
        $candidate_employment->department = $request->department[$j];
        $candidate_employment->start_date = $request->start_date[$j];
        if(!isset($request->current_job[$j])){
            // dd($request->end_date);
            $candidate_employment->end_date = $request->end_date[$j];
        }
        $candidate_employment->responsibilites = $request->responsibilites[$j];
        $candidate_employment->created_by = Auth::user()->id;
        $candidate_employment->department = $request->department[$j];
        $candidate_employment->duration = $request->duration_emp[$j];
        // dd($candidate_employment);
        $candidate_employment->save();

        return true;
    }

    public function getMasterData($id=array()){
        $masterData = [];
        $data = Masterconfig::whereIn('id', $id)->get();
        foreach($data as $d){
            $masterData[$d->type][$d->id] = $d->value;
        }
        return $masterData;
    }

}
?>
