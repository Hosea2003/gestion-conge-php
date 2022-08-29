<?php
    function getConges(){
        $conges = explode("#", file_get_contents(dirname(__DIR__)."\\Files\\Conge.txt"));
        $conges=array_filter($conges, "verifyEmp");
        $Conges=array();
        foreach($conges as $conge){
            $conge=explode("~", $conge);
            $Conges[] = new Conge($conge[0], $conge[1], $conge[2], $conge[3],  getEmployeeById($conge[0]));
        }
        return $Conges;
    }

    function getDemandeConge(){
        $conges = getConges();
        $Conges = array();
        foreach($conges as $conge){
            if($conge->getIsAccorde()=="not-seen" ||  $conge->getIsAccorde()=="seen"){
                $Conges[]=$conge;
            }
        }
        return $Conges;
    }

    function getCongeNotif(){
        $conges = getConges();
        $Conges = array();
        foreach($conges as $conge){
            if($conge->getIsAccorde()=="not-seen"){
                $Conges[]=$conge;
            }
        }
        return $Conges;
    }

    class Conge{
        private $id;
        private $date_debut;
        private $date_fin;
        private $employee;
        private $isAccorde;//not-seen; accorde;non-accorde//seen

        /**
         * @param $id
         * @param $date_debut
         * @param $date_fin
         * @param $employee
         */
        public function __construct($id, $date_debut, $date_fin, $isAccorde, $employee)
        {
            $this->id = $id;
            $this->date_debut = $date_debut;
            $this->date_fin = $date_fin;
            $this->isAccorde= $isAccorde;
            $this->employee = $employee;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getDateDebut()
        {
            return $this->date_debut;
        }

        /**
         * @param mixed $date_debut
         */
        public function setDateDebut($date_debut)
        {
            $this->date_debut = $date_debut;
        }

        /**
         * @return mixed
         */
        public function getDateFin()
        {
            return $this->date_fin;
        }

        /**
         * @param mixed $date_fin
         */
        public function setDateFin($date_fin)
        {
            $this->date_fin = $date_fin;
        }

        /**
         * @return mixed
         */
        public function getEmployee()
        {   
            return $this->employee;
        }

        /**
         * @return mixed
         */
        public function getIsAccorde()
        {
            return $this->isAccorde;
        }

        /**
         * @param mixed $isAccorde
         */
        public function setIsAccorde($isAccorde)
        {
            $this->isAccorde = $isAccorde;
        }

        // /**
        //  * @param mixed $employee
        //  */
        // public function setEmployee($employee)
        // {
        //     $this->employee = $employee;
        // }

        




    }
?>