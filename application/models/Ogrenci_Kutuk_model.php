<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ogrenci_Kutuk_model extends CI_Model
{
   private $table_name = "ogrenci_kutuk";
   public function all(array $where = array(), string $select = "ogrenci_kutuk.kurum_kodu, ogrenci_kutuk.kurum_adi, ogrenci_kutuk.ILCE_ADI as ilce_adi, ogrenci_kutuk.opaq, ogrenci_kutuk.ogr_no, ogrenci_kutuk.ogr_adi, ogrenci_kutuk.ogr_soyadi, ogrenci_kutuk.subesi, ogrenci_kutuk.SINIF_KODU"): array|object
   {
      $this->db->select($select);
      $this->db->where($where);
      $this->db->from($this->table_name);
      $this->db->order_by('ogrenci_kutuk.ILCE_ADI, ogrenci_kutuk.KURUM_ADI, ogrenci_kutuk.sinif_kodu', 'ASC');
      return $this->db->get()->result();
   }

   public function count($where = array()): int
   {
      return $this->db->where($where)->from($this->table_name)->count_all_results();
   }

   public function get_all_w($where = array(), $order = "subesi")
   {
      return $this->db->select("subesi")->where($where)->order_by($order)->distinct()->get($this->table_name);
      //echo $this->db->last_query();
      //die();
   }

   /**
    * @description Öğrenci Listesi Getir
    * @param array $where
    * @param string $order
    * @return object|array
    */
   public function get_students(array $where = array(), string $order = "ogrenci_kutuk.SUBESI, ogrenci_kutuk.OGR_NO asc"): object|array
   {
      return $this->db->where($where)->order_by($order)->get($this->table_name)->result();
   }

   public function sinif_ogrenci_listesi_getir($where = array(), $order = "ogrenci_kutuk.ogr_no ASC"): object|array
   {
      $this->db->select('ogrenci_kutuk.opaq, ogrenci_kutuk.ogr_no, ogrenci_kutuk.ogr_adi, ogrenci_kutuk.ogr_soyadi, ogrenci_kutuk.subesi');
      return $this->db->where($where)->order_by($order)->get($this->table_name)->result();
   }

   public function ogrenci_listesi_getir($where = array(), $order = "ogrenci_kutuk.SUBESI, ogrenci_kutuk.OGR_NO asc")
   {
      $this->db->select('ogrenci_kutuk.OPAQ, ogrenci_kutuk.OGR_NO, ogrenci_kutuk.OGR_ADI, ogrenci_kutuk.OGR_SOYADI, ogrenci_kutuk.SUBESI, ogrenci_kutuk.BARKOD');
      return $this->db->where($where)->order_by($order)->get($this->table_name)->result();
   }

   public function get_all_w_kurum_detay(array $where = array(), string $order = "TownName asc"): mixed
   {
      $this->db->select(
        'okullar.kurum_adi,
                okullar.kurum_kodu,
                okullar.KURUM_ADI as kurum_adi,
                city.CityName as il_adi,
                town.TownName as ilce_adi,
                sinavlar.*'
      );

      $this->db->from($this->table_name);
      $this->db->where($where);
      $this->db->join('okullar', 'ogrenci_kutuk.kurum_kodu = okullar.kurum_kodu');
      $this->db->join('city', 'okullar.IL_ID = city.CityID');
      $this->db->join('town', 'okullar.ILCE_ID = town.TownID');
      $this->db->join('sinavlar', 'ogrenci_kutuk.sinav_id = sinavlar.id');
      $this->db->order_by($order);
      return $this->db->get()->row();
   }

   public function GetIlceOkulListesi($where = array(), $order = "ogrenci_kutuk.kurum_kodu asc"): object|array
   {
      $this->db->select('ogrenci_kutuk.kurum_kodu, ogrenci_kutuk.KURUM_ADI, ogrenci_kutuk.ILCE_ADI');
      $this->db->group_by('ogrenci_kutuk.kurum_kodu');
      return $this->db->where($where)->order_by($order)->get($this->table_name)->result();
   }

   public function select_distint($sinavID)
   {
      /*$this->db->join('dersler', 'sinavlar.ders_id = dersler.id');
      $this->db->group_by('kurum_kodu');
      $this->db->order_by('kurum_kodu', 'ASC');
      $query = $this->db->get($this->table_name);
      return $query;*/
      $this->db->select('ogrenci_kutuk.kurum_kodu, okullar.KURUM_ADI as kurum_adi, city.CityName, town.TownName');
      $this->db->from($this->table_name);
      $this->db->where('sinav_id', $sinavID);
      $this->db->where('sinif_no', $sinavID);
      $this->db->join('okullar', 'ogrenci_kutuk.kurum_kodu = okullar.kurum_kodu');
      $this->db->join('city', 'okullar.IL_ID = city.CityID');
      $this->db->join('county', 'okullar.ILCE_ID = town.TownID');
      //$this->db->join('sinavlar', 'okullar_sinavlar.sinav_id = sinavlar.id');
      $this->db->group_by('ogrenci_kutuk.kurum_kodu');
      //$this->db->distinct();
      return $this->db->get()->result();
   }

   public function sinav_okullar_getir(array $where = array()): object|array
   {
      $this->db->select("ogrenci_kutuk.kurum_kodu, ogrenci_kutuk.KURUM_ADI as kurum_adi, ogrenci_kutuk.IL_ADI, ogrenci_kutuk.ILCE_ADI");
      $this->db->from($this->table_name);
      $this->db->where($where);
      $this->db->group_by('ogrenci_kutuk.kurum_kodu');
      $this->db->order_by('ogrenci_kutuk.ILCE_ADI, ogrenci_kutuk.KURUM_ADI', 'ASC');
      return $this->db->get()->result();
   }

   public function sinav_okullar_sinif_getir($sinavBakanlikID, $kurum_kodu)
   {
      $this->db->select('ogrenci_kutuk.SINIF_KODU, ogrenci_kutuk.SUBESI');
      $this->db->from($this->table_name);
      $this->db->where('sinav_id', $sinavBakanlikID);
      $this->db->where('kurum_kodu', $kurum_kodu);
      $this->db->group_by('ogrenci_kutuk.SINIF_KODU');
      $this->db->order_by('ogrenci_kutuk.SUBESI', 'ASC');
      return $this->db->get()->result();
   }

   public function sinava_okullar_getir($sinavBakanlikID)
   {
      $this->db->select('ogrenci_kutuk.kurum_kodu, ogrenci_kutuk.KURUM_ADI as kurum_adi, ogrenci_kutuk.ILCE_ADI as ilce_adi');
      $this->db->from($this->table_name);
      $this->db->where('sinav_id', $sinavBakanlikID);
      $this->db->group_by('ogrenci_kutuk.kurum_kodu');
      $this->db->order_by('ogrenci_kutuk.ILCE_ADI, ogrenci_kutuk.KURUM_ADI', 'ASC');
      return $this->db->get()->result();
   }

   public function okul_sayisini_getir($sinavID)
   {
      $this->db->select('ogrenci_kutuk.kurum_kodu');
      $this->db->distinct();
      $this->db->from($this->table_name);
      $this->db->where('sinav_id', $sinavID);
      return $this->db->count_all_results();
   }

   public function ilce_okul_sayisini_getir($where = array())
   {
      $this->db->select('ogrenci_kutuk.kurum_kodu');
      $this->db->distinct();
      $this->db->from($this->table_name);
      $this->db->where($where);
      return $this->db->count_all_results();
   }

   public function okul_sinif_sayisini_getir($where = array())
   {
      $this->db->select('ogrenci_kutuk.SINIF_KODU');
      $this->db->distinct();
      $this->db->from($this->table_name);
      $this->db->where($where);
      return $this->db->count_all_results();
   }

   public function okul_ogrenci_sayisini_getir($where = array()): int
   {
      return $this->db->from($this->table_name)->where($where)->count_all_results();
   }

   public function sinav_kurum_kodu_getir($sinav_id): object|array
   {
      $this->db->select('ogrenci_kutuk.KURUM_KODU, ogrenci_kutuk.KURUM_ADI, ogrenci_kutuk.ILCE_ADI as ilce_adi, ogrenci_kutuk.SINIF_KODU');
      $this->db->from($this->table_name);
      $this->db->where('SINAV_ID', $sinav_id);
      $this->db->group_by('ogrenci_kutuk.KURUM_KODU');
      $this->db->order_by('ogrenci_kutuk.ILCE_ADI, ogrenci_kutuk.KURUM_KODU', 'ASC');
      return $this->db->get()->result();
   }

   public function sinav_kurum_kodu_getir_ilce($sinavBakanlikID, $ilce_adi)
   {
      $this->db->select('ogrenci_kutuk.kurum_kodu, ogrenci_kutuk.kurum_adi');
      $this->db->from($this->table_name);
      $this->db->where('SINAV_ID', $sinavBakanlikID);
      $this->db->where('ILCE_ADI', $ilce_adi);
      $this->db->group_by('ogrenci_kutuk.kurum_kodu');
      $this->db->order_by('ogrenci_kutuk.kurum_kodu', 'ASC');
      return $this->db->get()->result();
   }


   /**
    * @param array $where
    * @return object|array
    */
   public function sinav_bazli_sinif_listesi_kurum_sinif_kodlarini_getir(array $where = array()): object|array
   {
      $this->db->where($where);
      $this->db->from($this->table_name);
      $this->db->select('ogrenci_kutuk.SUBESI, ogrenci_kutuk.SINIF_KODU');
      $this->db->group_by('ogrenci_kutuk.SINIF_KODU');
      $this->db->order_by('ogrenci_kutuk.SINIF_KODU', 'ASC');
      return $this->db->get()->result();
   }

   public function insert($data): void
   {
      $this->db->insert_batch($this->table_name, $data);
   }

   public function add($data): bool
   {
      return $this->db->insert($this->table_name, $data);
   }

   public function delete($where = array()): mixed
   {
      return $this->db->where($where)->delete($this->table_name);
      // $this->db->save_queries = TRUE; //Turn ON save_queries for temporary use.
      // $str = $this->db->last_query();
      // echo $str;
      // die();
   }

   public function ogrenci_kutuk_yukle($data): bool
   {
      return $this->db->insert($this->table_name, $data);
   }

   public function okul_subeleri_listele($kurum_kodu): object|array
   {
      $this->db->from($this->table_name);
      $this->db->where('kurum_kodu', $kurum_kodu);
      $this->db->group_by('ogrenci_kutuk.SINIF_KODU');
      $this->db->order_by('ogrenci_kutuk.SUBESI', 'ASC');
      $this->db->select('ogrenci_kutuk.SINIF_KODU, ogrenci_kutuk.SUBESI');
      return $this->db->get()->result();
   }
}
