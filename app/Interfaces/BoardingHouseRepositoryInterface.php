<?php

namespace App\Interfaces;

interface BoardingHouseRepositoryInterface
{
    public function getAllboardinghouses($search = null, $city = null, $category = null);
    //mengambil data semua kost, dengan filter pencarian, kota, dan kategori

    public function getPopularboardinghouses($limit = 5);
    //mengambil data 5 kost paling populer

    public function getboardinghousesByCitySlug($slug);
    //mengambil data kost berdasarkan slug kota 
    
    public function getboardinghousesByCategorySlug($slug);
    //mengambil data kost berdasarkan slug kategori

    public function getboardinghousesBySlug($slug);
    //mengambil data kost berdasarkan slug 
}
