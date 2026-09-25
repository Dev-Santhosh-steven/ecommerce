<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function about()
    {
        return view('store.about');
    }

    public function eWaste()
    {
        $collectionCentres = [
            ['state' => 'Delhi', 'location' => 'Raangpuri', 'address' => '198, G/F Malikpur Kohi, Next to hero honda Service Station, Rangpuri, Mahipalpur EXT. New Delhi, Delhi – 110037'],
            ['state' => 'Haryana', 'location' => 'Gurugram', 'address' => 'J-171, New Palam Vihar Phase-1, Gurgaon, Gurugram, Haryana 122017'],
            ['state' => 'Jharkhand', 'location' => 'Dhanbad', 'address' => 'Sardar Patel Nagar, Dhanbad, Jharkhand – 826004'],
            ['state' => 'Uttar Pradesh', 'location' => 'Noida', 'address' => 'BH-122, Sector -70, Noida, Uttar Pradesh 201301'],
            ['state' => 'Manipur', 'location' => 'Manipur', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Maharashtra', 'location' => 'Mumbai', 'address' => 'Plot-92, gala no.-01, Sector 19C Vashi Navi, Mumbai – 400705'],
            ['state' => 'Maharashtra', 'location' => 'Pune', 'address' => 'Plot No-24, Sec No-4, Shikshak Colony, Near Spine City, Moshi Pradhikaran, Pune – 412105'],
            ['state' => 'Odisha', 'location' => 'Cuttack', 'address' => '1st Floor Deltahouse, Rajendra Nagar, Madhupatna Cuttack, Bhubaneshwar'],
            ['state' => 'Manipur', 'location' => 'Manipur', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Telangana', 'location' => 'Hyderabad', 'address' => '4, Block-3, 4th Shatter at 179, MPR Estates near Old check post Old Bowaenpally Secunderabad, Hyderabad – 500011'],
            ['state' => 'Arunachal Pradesh', 'location' => 'Arunachal Pradesh', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Karnataka', 'location' => 'Bangalore', 'address' => 'No.43 1st Floor 2nd main D.D.U.T.T.L. Yeshwantpur, Bangalore – 560022'],
            ['state' => 'Karnataka', 'location' => 'Mangalore', 'address' => 'Opp. Hindustan Lever Ltd, Sulthan, Bhathery road Boloor Mangalore (KA) – 575003'],
            ['state' => 'Jharkhand', 'location' => 'Ranchi', 'address' => 'Ranchi, Jharkhand. # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Tamil Nadu', 'location' => 'Chennai', 'address' => '27, Sakthi Nagar Phase II, Sennerkuppam, Near Bisleri Water Plant, Chennai – 600056'],
            ['state' => 'Rajasthan', 'location' => 'Jaipur', 'address' => 'A-81, 200 ft. By Pass, Heerapura, Jaipur, Rajasthan – 302021'],
            ['state' => 'Sikkim', 'location' => 'Sikkim', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Odisha', 'location' => 'Bokaro', 'address' => '1st Floor Deltahouse, Rajendra Nagar, Madhupatna Cuttack, Bhubaneshwar'],
            ['state' => 'Assam', 'location' => 'Guwahati', 'address' => 'HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati – 781029'],
            ['state' => 'Tripura', 'location' => 'Tripura', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Uttar Pradesh', 'location' => 'Lucknow', 'address' => 'S-317, Transport Nagar, Behind RTO Office, Lucknow, Uttar Pradesh 226012'],
            ['state' => 'Madhya Pradesh', 'location' => 'Indore', 'address' => '284 AS-3 Scheme No – 78, Vijay Nagar, Indore, Madhya Pradesh'],
            ['state' => 'West Bengal', 'location' => 'Siliguri', 'address' => 'Siliguri, West Bengal. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Gujarat', 'location' => 'Ahmedabad', 'address' => 'Shop No D18, Pushp Penament, Behind Mony Hotel, Isanpur, Ahmedabad'],
            ['state' => 'Bihar', 'location' => 'Patna', 'address' => 'Dr. A.K Pandey (IPS), Malyanil Buddha Colony, Patna, Bihar – 800001'],
            ['state' => 'Nagaland', 'location' => 'Nagaland', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Meghalaya', 'location' => 'Shillong', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Mizoram', 'location' => 'Mizoram', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Andhra Pradesh', 'location' => 'Vishakhapatnam', 'address' => 'Shop No.8, New Gajuwaka, Opp. High School Road, Vishakhapatnam, Andhra Pradesh – 530026'],
            ['state' => 'Punjab', 'location' => 'Chandigarh', 'address' => 'Shop No. 15 & 16, Pabhat Road, Opp. Tennis Academy, Zirakpur, Chandigarh, Punjab – 140603'],
            ['state' => 'West Bengal', 'location' => 'Kolkata', 'address' => '156A/73, Northern Park, B.T. Road, Dunlop, Kolkata – 700108'],
            ['state' => 'Jharkhand', 'location' => 'Jamshedpur', 'address' => 'Jamshedpur, Jharkhand. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Chhattisgarh', 'location' => 'Raipur', 'address' => 'Raipur, Chhattisgarh. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Odisha', 'location' => 'Bhubaneshwar', 'address' => 'Acharya Vihar-Jaydev Vihar Road, Bhubaneshwar, Odisha, India'],
            ['state' => 'Maharashtra', 'location' => 'Nagpur', 'address' => 'Nagpur, Maharashtra. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'West Bengal', 'location' => 'Asansol', 'address' => 'Shop No-4, Asansol Station Bus Stand Road, Munshi Bazar, Asansol, West Bengal 713301'],
            ['state' => 'Andhra Pradesh', 'location' => 'Secunderabad', 'address' => 'Shop No.4, Block-3, 4th Shatter at 179, MPR Estates, Near Old Check Post, Old Bowenpally, Secunderabad, Hyderabad – 500011'],
            ['state' => 'Goa', 'location' => 'Goa', 'address' => 'Goa. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Himachal Pradesh', 'location' => 'Dharamshala', 'address' => 'Dharamshala, Himachal Pradesh. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Jammu & Kashmir', 'location' => 'Jammu', 'address' => 'Jammu, Jammu & Kashmir. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Kerala', 'location' => 'Cochin', 'address' => 'Cochin, Kerala. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Uttarakhand', 'location' => 'Rudrapur', 'address' => 'Rudrapur, Uttarakhand. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
        ];

        return view('store.ewaste', compact('collectionCentres'));
    }

    public function terms()
    {
        return view('store.terms');
    }

    public function warranty()
    {
        return view('store.warranty');
    }

    public function privacy()
    {
        return view('store.privacy');
    }

    public function delivery()
    {
        return view('store.delivery');
    }

    public function contact()
    {
        return view('store.contact');
    }
}
