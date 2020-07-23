# iHelp-api
iHelp-api is a web api application, a CRUD (Create, Read, Update and Delete) where a user can find free parking spots, in different parts of a city.
It has a login systems, with token authentication.
The application is using Symfony 4.4 with php 7.3

# Routes 
create_city                  POST     ANY      ANY    /createCity
parameters: name        
create_parking_place         POST     ANY      ANY    /createParkingPlace
parameters: zoneId, address, numberParkingSpotsTotal, numberParkingSpotsFree, pricePerHour, currency                  
get_free_parking_spots       POST     ANY      ANY    /getFreeParkingSpots                 
parameters: id, by
create_parking_spot          POST     ANY      ANY    /createParkingSpot 
parameters: parkingPlaceId, vehicleId, expireAt                  
app_register_register        POST     ANY      ANY    /register
parameters: email, password, address, firstName, lastName, phoneNumber, country, city                        
app_login                    POST     ANY      ANY    /login
parameters: email, password      
app_logout                   ANY      ANY      ANY    /logout                              
edit_user                    POST     ANY      ANY    /editUser 
parameters: userId, email, password, address, firstName, lastName, phoneNumber, country, city                            
get_user                     POST     ANY      ANY    /getUser
parameters: userId                             
create_vehicle               POST     ANY      ANY    /createVehicle
parameters: userId, licensePlate                       
create_zone                  POST     ANY      ANY    /createZone
parameters: name, address, cityId

# Flow
A user can have multiple vehicles
A city can have multiple zones (neighborhood)
A zone can have multiple parking places
A parking place can have multiple parking spots

#Command
php bin/console app:delete-spots
A command that deletes the expired spots, and resets the counting number of the place.
To be used as a cron.

# Api Platform Note
In order that an entity to be shown in on /api/docs that entity must contain in class annotation "@ApiPlatform()"