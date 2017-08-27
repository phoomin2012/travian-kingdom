# Travian Kingdom Clone Script
This project is clone Travian Kingdom game. Now, **not finish** yet.<br>
If you want to support, you can donate us by Paypal. https://paypal.me/PhuminShop<br>
Bitcoin Address : 1MaVc6fVKvdggg5KZXHYTwAVGrfTQQ7b45

# Menu
  - [Menu](#menu)
  - [Feature](#feature)
  - [Screenshot](#screenshot)
  - [Requires](#requires)
  - [Installation](#installation)
  - [Subscribe](#subscribe)

# Feature
- Index
  - [ ] Start without account
- Lobby
  - Achievements
    - [ ] Achievements list
    - [ ] Prestige
    - [ ] Cliam prestige
  - Avatar
    - [ ] Set sitters
    - [ ] Set duals
  - Game worlds
    - [x] Join game worlds
    - [ ] List playing game worlds
    - [ ] List playing game worlds that sitters
    - [ ] Remove avatar
  - News
    - [ ] Show news
  - Account
    - [x] Login
    - [x] Register
    - [ ] Change picture avatar
    - [ ] Change email
    - [ ] Change password
    - [ ] Change account name
    - [ ] Subscribe to newsletter
    - [ ] Logout
- Game
  - Building list
    - [x] Construct building
    - [x] Upgrade building
    - [x] Master building
    - [x] Resort building list
    - [x] Cancel building
    - [x] Buy more slot
    - [x] Reserve resource
    - [x] Finish now
  - Troops & Merchants
    - [x] Train troop
    - [x] Send attack (no attack)
    - [ ] Send raid (no attack)
    - [ ] Send siege (no attack)
    - [x] Settle new village
    - [ ] Conqure village
    - [x] Send resources
  - Hero
    - [x] Adventure (generate item with no effect)
    - [ ] Attack
    - [ ] Reinforcement
    - [x] Inventory
    - [x] Attributes
    - [x] Change hero face
    - [x] Hero equipment
  - Silver & Gold
    - [x] Exchange sliver & gold
    - [ ] Travian Plus
    - [x] Resource bonus
    - [x] Crop bonus
    - [ ] Starter pack
    - [ ] Invite friends
    - [ ] Purchase gold
    - [ ] Auto extend
    - [x] Lifetime bonus
  - Report
    - [ ] Attack report (not correct infomation)
    - [ ] Raid report
    - [ ] Siege report
    - [ ] Spy report
    - [ ] Defense report
    - [ ] Reinforces report
    - [x] Advanture report
    - [ ] Trade report
    - [ ] Reinforces arrived report
    - [ ] Animal caught repor
    - [ ] Visit report
    - [ ] Weeky prestige
    - [ ] Share report
    - [ ] Favorites report
  - Message
    - [ ] Private message
    - [ ] Kingdom message
    - [ ] Secret society message
    - [ ] Kingdom chat
    - [ ] Beginner chat
    - [ ] Global chat
  - Statistics
    - Player
      - [ ] Overview
      - [ ] Attacker
      - [ ] Defender
      - [ ] Villages
      - [ ] Heroes
      - [ ] Top 10
      - [ ] Search
    - Kingdom
      - [ ] Victory points
      - [ ] Population
      - [ ] Area
      - [ ] Attacker
      - [ ] Defender
      - [ ] Top 10
      - [ ] Search
    - [x] World
  - Quest
    - [x] Tutorial gameplay
    - [ ] Tutorial governer
    - [ ] Tutorial king
    - [ ] Daliy quest
    - [ ] Quest
  - Setting
    - [ ] Change setting
    - [ ] Delete avatar
  - Prestige
    - [ ] Prestige
  - Player profile
    - [ ] Modal
    - [ ] Change description
  - Auction
    - [ ] Buy
    - [ ] Sell
    - [ ] Bids
    - [ ] Silver accounting (History)
  - Kingdom
    - [x] Create kingdom
    - [x] Change description
    - [x] Change tag
    - [x] Show member
    - [ ] Invite player
    - [ ] Invite dukes
    - [x] Treasure active
    - [ ] Internation statistics
    - [ ] Kingdom events
    - [ ] Ranking
    - [ ] Treasuries
    - [ ] Tributes
    - [ ] Diplomacy
    - [ ] Create offer
  - Notification
    - [x] Show notification
    - [x] Remove notification
    - [x] Remove all notification
  - Map
    - [x] Show map cell
    - [x] Show map cell detail
    - [x] Show village infomation
    - [x] Show oasis
    - [ ] Show oasis troops
    - [ ] Show report
    - [ ] Robber
    - [ ] NPC Village
    - [ ] Natar village
    - [ ] WW village
    - [x] Vocano
    - [x] Kingdom borders
    - [ ] Game messages
    - [ ] Player messages
    - [ ] Kingdom markers
    - [ ] Player markers
    - [ ] Fields markers
  - Oasis
    - [ ] Assign oasis
    - [ ] Oasis bonus
    - [ ] Give up oasis
    - [ ] Bonus from troops in oasis
  - Village & Building
    - [x] Upgrade to town
    - [ ] Celebration
    - [ ] Claim resource from hidden treasures
    - [ ] Extra building fields
    - [x] Research troops
    - [x] Finish now research
    - [x] Improve troops
    - [x] Finish now improve
    - [x] Demolish building
    - [x] Clear rubbles
  - Notepads
    - [ ] Show/hide notepad
    - [ ] Create a new note
    - [ ] Edit note
    - [ ] Delete note
  
# Screenshot
![Travian Kingdom Clone Script](https://s22.postimg.org/w82ihh4xt/Screen_Shot_2560-05-02_at_08.46.30.png)
![Travian Kingdom Clone Script](https://s12.postimg.org/3r5cbfrl9/Screen_Shot_2560-05-02_at_08.53.33.png)
![Travian Kingdom Clone Script](https://s1.postimg.org/s7flw3fjz/Screen_Shot_2560-05-02_at_09.03.02.png)
![Travian Kingdom Clone Script](https://s16.postimg.org/f3kdmw3gl/Screen_Shot_2560-05-02_at_09.15.02.png)
![Travian Kingdom Clone Script](https://s23.postimg.org/jlaolluaj/Screen_Shot_2560-05-02_at_09.15.26.png)
![Travian Kingdom Clone Script](https://s11.postimg.org/5vs1owv8z/Screen_Shot_2560-05-02_at_09.18.24.png)

# Requires
  - PHP 5.6+ (with PDO mysql)
  - Node.JS
  
*** IMPORTANT *** This script can't use in web hosting because automatice function run as service

# Installation
  1. Perpair web server program (very simple use xampp)
    - Prepair subdomain and point to your server
    - Config apache vhost for game
    
Example vhost config for apache (OSX with xampp)
```
<VirtualHost *:80>
    # Index
    ServerAdmin t5.ph
    ServerName t5.ph
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/travian5"
    ErrorLog "logs/t5.ph-error_log"
    CustomLog "logs/t5.ph-access_log" common
</VirtualHost>
<VirtualHost *:80>
    # Index
    ServerAdmin kingdoms.t5.ph
    ServerName kingdoms.t5.ph
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/travian5/index"
    ErrorLog "logs/kingdoms.t5.ph-error_log"
    CustomLog "logs/kingdoms.t5.ph-access_log" common
</VirtualHost>
<VirtualHost *:80>
    # Mellon service (Account service)
    ServerAdmin mellon.t5.ph
    ServerName mellon.t5.ph
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/travian5/mellon"
    ErrorLog "logs/mellon.t5.ph-error_log"
    CustomLog "logs/mellon.t5.ph-access_log" common
    Header set Access-Control-Allow-Origin "*"

    AllowEncodedSlashes on
</VirtualHost>
<VirtualHost *:80>
    # CDN
    ServerAdmin cdn.t5.ph
    ServerName cdn.t5.ph
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/travian5/cdn"
    ErrorLog "logs/cdn.t5th.ph-error_log"
    CustomLog "logs/cdn.t5th.ph-access_log" common
    Header set Access-Control-Allow-Origin "*"
</VirtualHost>
<VirtualHost *:80>
    # Lobby
    ServerAdmin lobby.t5.ph
    ServerName lobby.t5.ph
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/travian5/lobby"
    ErrorLog "logs/lobby.t5.ph-error_log"
    CustomLog "logs/lobby.t5.ph-access_log" common
</VirtualHost>
<VirtualHost *:80>
    # Game
    ServerAdmin ks1.t5.ph
    ServerName ks1.t5.ph
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/travian5/game/s1"
    ErrorLog "logs/ks1.t5.ph-error_log"
    CustomLog "logs/ks1.t5.ph-access_log" common
</VirtualHost>
```
Example hosts file
```
# Travian Kingdom
127.0.0.1       t5.ph
127.0.0.1       kingdoms.t5.ph
127.0.0.1       mellon.t5.ph
127.0.0.1       lobby.t5.ph
127.0.0.1       cdn.t5.ph
127.0.0.1       ks1.t5.ph
```

  2. Import database from travian5.sql<br>
    If you want empty data, you should empty every table except ```global_server_data```<br>
    If you want to change speed world, you can edit in ```global_server_data``` table too<br>
  3. Config mysql password in ```/config.php```
  4. Start automatice process with command ```php server2/server.php``` and ```node server/app2``` and ```node server_lobby/app``` (don't forget to install nodejs module with ```npm install``` before run)
  5. Let's enjoy your server
  
  **To generate world**<br>
  go to sub domain that game avaliable. go to api folder and go to debug.php?a=createWorld<br>
  for example `ks1.t5.ph/api/debug.php?a=createWorld`
  
Please note that this script doesn't finish yet.
If you found bug please use [Issues](https://github.com/phoomin2012/travian-kingdom-clone/issues) to report and use [Pulls Requests](https://github.com/phoomin2012/travian-kingdom-clone/pulls) to request feature that offical have or fix bug or add new feature to main project.
 
# Subscribe
***NOW IS FREE***<br>
Use **watch** button if you want to know about activities.<br>
If you **like** this project, please give **star**.<br>
NOT recommend to fork.<br>
***THANKS***
