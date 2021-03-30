<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Model{
  protected $table = 'location';

  public function AddLocation($city, $province, $country){
    $data = array('city' => $city,
                  'province' => $province,
                  'country' => $country
                );

    $this->db->insert($this->table, $data);
  }

  public function GetCountries(){
    $this->db->select("country");
    $this->db->distinct();
    $query = $this->db->get($this->table);

    return $query->result_array();
  }

  public function GetProvinceForCountry($country){
    $this->db->select("province");
    $this->db->distinct();
    $this->db->where('country', $country);
    $query = $this->db->get($this->table);

    return $query->result_array();
  }

  public function GetCitiesForProvince($province){
    $this->db->select("city");
    $this->db->select("locationId");
    $this->db->where('province', $province);
    $query = $this->db->get($this->table);

    return $query->result_array();
  }

  public function GetLocationById($locationId){
    $this->db->where('locationId', $locationId);
    $query = $this->db->get($this->table);
    $location = $query->result_array();

    return $location[0];
  }
}
?>
