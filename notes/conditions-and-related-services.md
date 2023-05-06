Following is a list of vehicle conditions a customer would want to get their vehicle checked for and fixed in a vehicle
service center.
I'm building a reporting system for a vehicle service center. The system will be used by the service center to record
the condition of a vehicle and the services provided to the vehicle. The system will also be used by the customer to
view the condition of their vehicle and the services provided to the vehicle. The system will also be used by the
service center to generate reports for the customer.
I'm building this in such a way that each of these conditions must be connected to an appropriate service, so that I can
show service suggestions based on the overall condition of the vehicle.So I'm including service_code as a foreign key in
each condition record.
Can you give me the list of services to be in the database tp satisfy following condition, please use industry-standard
names because I need to present them in a human-friendly way

- Engine Noise
- Viper Blades
- Head lights - Lights
- Parking lights - Lights
- Break lights - Lights
- Signal lights - Lights
- License Plate lights - Lights
- Battery level
- Cables & Carries
- Engine oil - Fluid levels
- Transmission oil - Fluid levels
- Clutch fluid - Fluid levels
- Washer fluid - Fluid levels
- Radiator fluid - Fluid levels
- Air Conditioning
- Fuel filter - Filters
- Oil filter - Filters
- Air filter - Filters
- LF - Tyre pressure
- RF - Tyre pressure
- LR - Tyre pressure
- RR - Tyre pressure
- Spare - Tyre pressure
- Breaks

```sql
-- I have created a table for services like this, can you give me a sql query to enter all those service you gave me?
-- remember that our currency unit is LKR, 1 USD = 300 LKR approximately, so please use reasonable prices for the services
CREATE TABLE `service`
(
    `servicecode`     int                                                            NOT NULL AUTO_INCREMENT,
    `price`           int                                                            NOT NULL,
    `service_name`    varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NOT NULL,
    `description`     varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `is_discontinued` tinyint(1)                                                     NOT NULL DEFAULT '0',
    PRIMARY KEY (`servicecode`)
)
```

These were services created with your command with the corresponding service codes.
8 - Engine Diagnosis and Repair             
9 - Wiper Blade Replacement                 
10 - Headlight Bulb Replacement             
11 - Parking Light Bulb Replacement         
12 - Brake Light Bulb Replacement           
13 - Turn Signal Bulb Replacement           
14 - License Plate Light Bulb Replacement   
15 - Battery Testing and Replacement        
16 - Battery Cable and Terminal Replacement
17 - Oil Change Service                     
18 - Transmission Fluid Service             
19 - Clutch Fluid Replacement               
20 - Washer Fluid Refill                    
21 - Radiator Coolant Service               
22 - Air Conditioning Service               
23 - Fuel Filter Replacement                
24 - Oil Filter Replacement                 
25 - Air Filter Replacement                 
26 - Tire Pressure Check and Adjustment     
27 - Brake Inspection

Now I have following table. And the conditions I gave you before are stored in this table.

```mysql
 CREATE TABLE `inspectioncondition`
 (
     `condition_id`   int                                                            NOT NULL AUTO_INCREMENT,
     `condition_name` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
     `service_code`   int DEFAULT NULL,
     `category_id`    int DEFAULT NULL,
     PRIMARY KEY (`condition_id`),
     KEY `relates to a service` (`service_code`),
     KEY `relates a product category` (`category_id`),
     CONSTRAINT `relates a product category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON UPDATE CASCADE,
     CONSTRAINT `relates to a service` FOREIGN KEY (`service_code`) REFERENCES `service` (`servicecode`) ON UPDATE CASCADE
 )
```

As you can guess, they weren't connected with any service codes when I entered them.But since you have created services
for me, can you give me the complete set of query that will update the existing conditions with corresponding
service_code?

I've got the following category table

```mysql
CREATE TABLE `category`
(
    `category_id` int                                                           NOT NULL AUTO_INCREMENT,
    `name`        varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`category_id`),
    UNIQUE KEY `category name` (`name`) USING BTREE
);
```

I also currently have these categories in the database

2 - Air Filter                   
4 - Break pads                   
1 - Engine oil                   
6 - Lights                       
7 - Multimedia                   
5 - Oil filter                   
3 - Side Mirror

Can you give me the mysql query to enter the missing categories from your suggested category list

I have a model table with following structure

```mysql
CREATE TABLE `model`
(
    `model_id`   int                                                           NOT NULL AUTO_INCREMENT,
    `brand_id`   int                                                           NOT NULL,
    `model_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`model_id`),
    KEY `model_name` (`model_name`),
    KEY `brand has model` (`brand_id`),
    CONSTRAINT `brand has model` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`) ON DELETE RESTRICT ON UPDATE CASCADE
)
```

I have a brand table with following structure

```mysql
CREATE TABLE `brand`
(
    `brand_id`   int                                                                                              NOT NULL AUTO_INCREMENT,
    `brand_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci                                    NOT NULL,
    `brand_type` enum ('vehicle-brand','accessory-brand','both') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'both',
    PRIMARY KEY (`brand_id`),
    KEY `brand_name` (`brand_name`)
)
```

And a product table like this

```mysql
 CREATE TABLE `product`
 (
     `item_code`       int                                                                              NOT NULL AUTO_INCREMENT,
     `name`            varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci                    NOT NULL,
     `image`           json                                                                             NOT NULL,
     `price`           int                                                                              NOT NULL,
     `quantity`        int                                                                                       DEFAULT NULL,
     `description`     varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci                   NOT NULL,
     `product_type`    enum ('spare part','accessory') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
     `category_id`     int                                                                              NOT NULL,
     `model_id`        int                                                                              NOT NULL,
     `brand_id`        int                                                                              NOT NULL,
     `is_discontinued` tinyint(1)                                                                       NOT NULL DEFAULT '0',
     PRIMARY KEY (`item_code`),
     KEY `product name` (`name`),
     KEY `product is of model` (`model_id`),
     KEY `product is of category` (`category_id`),
     KEY `product is of brand` (`brand_id`),
     CONSTRAINT `product is of brand` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
     CONSTRAINT `product is of category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
     CONSTRAINT `product is of model` FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`) ON DELETE RESTRICT ON UPDATE CASCADE
 )
```

Can you keep these in mind when I ask the next set of questions?

I already have the following brands

brand_id - brand_name

58 - ACDelco                      
65 - Akebono                      
33 - Amsoil                       
79 - Aston Martin                 
24 - Audi                         
59 - Bendix                       
60 - Bendix Ultima                
61 - Bendix Ultima2               
80 - Bentley                      
69 - Bilstein                     
19 - BMW                          
26 - Bosch                        
43 - Bridgestone                  
81 - Bugatti                      
91 - Buggatti                     
2 - Caltex                        
32 - Castrol                      
11 - Chevrolet                    
50 - Citroen                      
41 - Continental                  
47 - Cooper Tire                  
62 - Delphi                       
27 - Denso                        
20 - Dodge                        
45 - Dunlop                       
63 - EBC Brakes                   
34 - ExxonMobil                   
5 - Fairbay                       
64 - Ferodo                       
77 - Ferrari                      
48 - Fiat                         
42 - Firestone                    
12 - Ford                         
72 - Gabriel                      
46 - General Tire                 
18 - GMC                          
39 - Goodyear                     
35 - Havoline                     
3 - Honda                         
10 - Honda                        
23 - Hyundai                      
57 - Jaguar                       
85 - Jaguar                       
15 - Jeep                         
21 - Kia                          
70 - KONI                         
66 - KYB                          
73 - KYB Gas-A-Just               
78 - Lamborghini                  
86 - Land Rover                   
76 - Lucas Oil                    
87 - Maserati                     
88 - Maybach                      
54 - Mazda                        
83 - McLaren                      
89 - Mercedes-AMG                 
25 - Mercedes-Benz                
38 - Michelin                     
90 - Mini                         
8 - Mitsubishi                    
55 - Mitsubishi                   
1 - Mobil                         
29 - Mobil                        
71 - Monroe                       
28 - NGK                          
14 - Nissan                       
52 - Opel                         
36 - Pennzoil                     
49 - Peugeot                      
40 - Pirelli                      
84 - Porsche                      
75 - Rain-X                       
16 - Ram                          
51 - Renault                      
92 - Rimac                        
93 - Rinspeed                     
82 - Rolls Royce                  
37 - Royal Purple                 
67 - Sachs                        
30 - Shell                        
94 - Spyker                       
17 - Subaru                       
7 - Suzuki                        
56 - Suzuki                       
13 - Tesla                        
68 - Textar                       
6 - Teyes                         
4 - Toyota                        
9 - Toyota                        
74 - Trico                        
31 - Valvoline                    
22 - Volkswagen                   
53 - Volvo                        
95 - W Motors                     
44 - Yokohama

I also have following models

model_id - model_name - brand_id
1 - 10w-30 - 1                                           
2 - 15w-40 - 1                                           
3 - A-898 - 3                                            
4 - A-280 - 3                                            
5 - A-196 - 4                                            
6 - KSP-90 - 4                                           
9 - BP-0222 - 4                                          
10 - YZZE1 - 4                                           
11 - LK-111539 - 5                                       
12 - X1 - 6                                              
13 - CIVIC EX - 3                                        
14 - Corolla - 4                                         
15 - Gixxer - 7                                          
16 - Lancer - 8                                          
17 - 1 - 1                                               
18 - Super 3000 - 1                                      
19 - Super 2000 - 1                                      
20 - Super - 1                                           
21 - Delvac - 1                                          
22 - Havoline - 2                                        
23 - Delo - 2                                            
24 - Vortex - 2                                          
25 - Diesel - 2                                          
26 - Diesel HPR - 2                                      
27 - Civic - 3                                           
28 - Accord - 3                                          
29 - CR-V - 3                                            
30 - HR-V - 3                                            
31 - Odyssey - 3                                         
32 - Corolla - 4                                         
33 - Camry - 4

When you're answering the next set of questions, please keep these in mind as well

These are the existing products in following format

model_id - brand_id - item_code - name
1 - 1 - 1 - Mobil 10w-30 FS 5L                                   
1 - 1 - 2 - Mobil Super? 1000 -10W-30                            
2 - 4 - 3 - Mobil Delvac? Super 1400 15W-40                      
1 - 2 - 4 - CALTEX Lanka Super DS SAE (5L + 1L Extra)15W-40      
2 - 2 - 5 - CALTEX Lanka Super DS SAE 15W-40                     
3 - 3 - 6 - Honda Air Filter 17220-5R0-008 A-898                 
4 - 3 - 7 - Honda Air Filter 17220-5AA-A00                       
5 - 4 - 8 - Toyota Air Filter 17801-23030 A196                   
6 - 52 - 9 - Toyota Vitz KSP90 Side Mirror                       
9 - 4 - 10 - Toyota Break pads rear Hilux vego, prado 150        
10 - 4 - 11 - Toyota Oil Filter 90915-YZZE1                      
11 - 5 - 12 - FairBay 16 LED Vehicle Spotlight - Fog light      
12 - 6 - 13 - TEYES X1 Multimedia Video Player                   
6 - 4 - 33 - Toyota Corolla KSP90 Side Mirror                    
9 - 3 - 34 - Honda civic Breaking Pads                           
9 - 3 - 35 - Honda Air Filter                                    
10 - 8 - 36 - AutoRealm Product