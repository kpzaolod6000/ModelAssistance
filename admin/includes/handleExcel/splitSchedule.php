
<?php

    // # horarios
    $h1 = "7:00-7:50";
    $h2 = "7:50-8:40";
    $h3 = "8:50-09:40";
    $h4 = "10:40-11:30";
    $h5 = "11:30-12:20";
    $h6 = "09:40-10:30";
    $h7 = "12:20-13:10";
    $h8 = "13:10-14:00";
    $h9 = "14:00-14:50";
    $h10 = "14:50-15:40";
    $h11 = "15:50-16:40";
    $h12 = "16:40-17:30";
    $h13 = "17:40-18:30";
    $h14 = "18:30-19:20";
    $h15 = "19:20-20:10";

    

    class Schedule_atrib 
    {
        public string $hour_ini;
        public string $hour_end;
        public string $type;
        public string $day;
        public string $group;
        public string $asignature;
        public int $classroom;
        public string $nameTeacher;

        public function __construct(string $hour_ini,string $hour_end,string $type,string $day,string $group,string $asignature,int $classroom,string $nameTeacher)
        {
            $this->hour_ini= $hour_ini;
            $this->hour_end = $hour_end;
            $this->type = $type;
            $this->day = $day;
            $this->group = $group;
            $this->asignature = $asignature;
            $this->classroom = $classroom;
            $this->nameTeacher = $nameTeacher;
        }
        
        
    }

    function splitData($data,$numClassGlobal,$day,$h,$ListSchedule)
    {
        $hour_ = explode("-",$h);
        $nameClass = explode(" - (", $data);
        $extractT = explode(") / ", $nameClass[1]);
        $extractA = explode(" - ", $nameClass[0]);
        $asignature = $extractA[0];
        $group = $extractA[1];
        $type = $extractT[0];
        $nameTeacher = $extractT[1];

        $mySchedule_atrib = new Schedule_atrib($hour_[0],$hour_[1],$type,$day,$group,$asignature,$numClassGlobal,$nameTeacher);
        array_push($ListSchedule,$mySchedule_atrib);
        return $ListSchedule;
        // return array($asignature, $group, $type, $nameTeacher);

    }
    
    
?>
