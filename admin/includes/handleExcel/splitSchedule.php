
<?php

    // # horarios
    $h1 = "07:00-07:50";
    $h2 = "07:50-08:40";
    $h3 = "08:50-09:40";
    $h4 = "09:40-10:30";
    $h5 = "10:40-11:30";
    $h6 = "11:30-12:20";
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
        //**Estructuras Discretas II - Grupo B - (Laboratorio) / YUBER ELMER VELAZCO PAREDES - Algoritmos y Estructuras de Datos - Grupo B - (Practica) /  ASHEY JOHN MASI*/
        
        //**Estructuras Discretas II - Grupo B*/ 0
        //**Laboratorio) / YUBER ELMER VELAZCO PAREDES - Algoritmos y Estructuras de Datos - Grupo B*/ 1
        //**Practica) /  ASHEY JOHN MASI*/ 2
        $hour_ = explode("-",$h);        
        $nameClass = explode(" - (", $data);

        if (count($nameClass) > 2) {
            $extractA_1 = explode(" - ", $nameClass[0]);
            $extractT_1 = explode(") / ", $nameClass[2]);
            $asignature_1 = $extractA_1[0];
            $group_1 = $extractA_1[1];

            $type_2 = $extractT_1[0];
            $nameTeacher_2 = $extractT_1[1];

            $extractT_2 = explode(") / ", $nameClass[1]);
            $type_1 = $extractT_2[0];
            $extract_other = explode(" - ", $extractT_2[1]);
            $nameTeacher_1 = $extract_other[0];
            $asignature_2 = $extract_other[1];
            $group_2 = $extract_other[2];


            $mySchedule_atrib_1 = new Schedule_atrib($hour_[0],$hour_[1],$type_1,$day,$group_1,$asignature_1,$numClassGlobal,$nameTeacher_1);
            array_push($ListSchedule,$mySchedule_atrib_1);
            $mySchedule_atrib_2 = new Schedule_atrib($hour_[0],$hour_[1],$type_2,$day,$group_2,$asignature_2,$numClassGlobal,$nameTeacher_2);
            array_push($ListSchedule,$mySchedule_atrib_2);
            
        }else{
            $extractT = explode(") / ", $nameClass[1]);
            $extractA = explode(" - ", $nameClass[0]);
            $asignature = $extractA[0];
            $group = $extractA[1];
            $type = $extractT[0];
            $nameTeacher = $extractT[1];
            
            $mySchedule_atrib = new Schedule_atrib($hour_[0],$hour_[1],$type,$day,$group,$asignature,$numClassGlobal,$nameTeacher);
            array_push($ListSchedule,$mySchedule_atrib);
        }
        
        return $ListSchedule;
        // return array($asignature, $group, $type, $nameTeacher);
    }    
?>
