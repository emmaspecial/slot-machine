<?php
require_once 'Appconfig.php';
//auth/register new user
$u1 = new User();

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bitcoin Slot Machine</title>
  <style type="text/css">
    body {
      background: url(images/test-bg.jpg) #0a1d35;
      color: white;
    }
    div#slots {
      position: relative;
      width: 900px;
      height: 700px;
      z-index: 1;
      margin: 50px auto;
    }
    div.slots-reel {
      position: absolute;
      top: 125px;
      z-index: 1;
      width: 100px;
      height: 375px;
      background: #000;
      overflow: hidden;
    }
    div#slots-reel1 {
      left: 125px;
    }
    div#slots-reel2 {
      left: 237px;
    }
    div#slots-reel3 {
      left: 349px;
    }
    
    div#slots-body {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 2;
      width: 900px;
      height: 700px;
      background: url(images/bsm-body.png);
    }    
    
    div#slots-body > * {
      position: absolute;
      z-index: 3;
      overflow: hidden;
    }        
    
    img#slots-logo {
      top: 96px;
      left: 96px;
    }
    img#slots-paytable {
      top: 162px;
      left: 638px;
    }
    
    div.slots-display {
      font-family: Tahoma, Arial, Helvetica, sans-serif;
      text-align: center;
      color: #3986ff;
      text-shadow: 0 0 6px #2982f2, 0 0 1px #2982f2;
    }
    
    div#slots-address {
      top: 534px;
      left: 578px;
      width: 232px;
      height: 24px;
      padding-top: 4px;
      font-size: 13px;
      letter-spacing: -1px;
    }
    
    div#slots-balance {
      top: 578px;
      left: 578px;
      width: 112px;
      height: 29px;
      padding-top: 5px;
      font-size: 16px;
      font-weight: bold;
      text-align: right;
    }  
    div#slots-bet {
      top: 516px;
      left: 242px;
      width: 92px;
      height: 36px;
      padding-top: 6px;
      font-size: 22px;
      font-weight: bold;
    }       
    
    button.slots-button {
      background: url(images/bsm-buttons.png);
      border: 0;
      cursor: pointer;
      outline: none;
    }
    
    button.slots-plus {
      left: 348px;
      width: 25px;
      height: 26px;
      background-position: 0 0;
    }
    button.slots-plus:hover {
      background-position: -25px 0;
    }
    button.slots-plus:active {
      background-position: -50px 0;
    }

    button.slots-minus {
      left: 203px;
      width: 25px;
      height: 26px;
      background-position: 0 -26px;
    }
    button.slots-minus:hover {
      background-position: -25px -26px;
    }
    button.slots-minus:active {
      background-position: -50px -26px;
    }
    
    button#slots-plus001, button#slots-minus001 {
      top: 486px;
    }
    button#slots-plus01, button#slots-minus01 {
      top: 513px;
    }
    button#slots-plus1, button#slots-minus1 {
      top: 540px;
    }

    button#slots-spin {
      top: 515px;
      left: 461px;
      width: 98px;
      height: 98px;
      background-position: 1px -191px;
    }
    button#slots-spin:hover {
      background-position: -97px -191px;
    }
    button#slots-spin:active {
      background-position: -195px -191px;
    }
    
    button.slots-bottombutton {
      top: 570px;
      width: 108px;
      height: 46px;
    }
    
    button#slots-lastbet {
      left: 121px;
      background-position: 0 -98px;
    }
    button#slots-lastbet:hover {
      background-position: -108px -98px;
    }
    button#slots-lastbet:active {
      background-position: -216px -98px;
    }

    button#slots-maxbet {
      left: 233px;
      background-position: 0 -52px;
    }
    button#slots-maxbet:hover {
      background-position: -108px -52px;
    }
    button#slots-maxbet:active {
      background-position: -216px -52px;
    }

    button#slots-autoplay {
      left: 345px;
      background-position: 0 -144px;
    }
    button#slots-autoplay:hover {
      background-position: -108px -144px;
    }
    button#slots-autoplay:active {
      background-position: -216px -144px;
    }    
    
    button#slots-cashout {
      top: 571px;
      left: 709px;
      width: 82px;
      background-position: -75px 0;
    }
    button#slots-cashout:hover {
      background-position: -157px 0;
    }
    button#slots-cashout:active {
      background-position: -239px 0;
    }        
    
    div.slots-line {
      width: 100px;
    }
    div.slots-line > div {
      width: 100px;
      height: 125px;
    }
    div.slots-symbol0 {
      background: url(images/bsm-symbol-nwo.png);
    }    
    div.slots-symbol1 {
      background: url(images/bsm-symbol-bitcoin.png);
    }    
    div.slots-symbol2 {
      background: url(images/bsm-symbol-anon.png);
    }    
    div.slots-symbol3 {
      background: url(images/bsm-symbol-onion.png);
    }    
    div.slots-symbol4 {
      background: url(images/bsm-symbol-anarchy.png);
    }    
    div.slots-symbol5 {
      background: url(images/bsm-symbol-peace.png);
    }    
    div.slots-symbol6 {
      background: url(images/bsm-symbol-empty.png);
    } 
  </style>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript">
    function Slot(uid){
      //todo: get config for slot (on client side) via Ajax Or use default config described here
      //default slot config
      this.uid = uid;
      this.currentBet = new Number(0);
      this.currentUserBalance = new Number(0);
      this.lastBet = new Number(0);
      //this.balanceBeforeLastBet = this.currentUserBalance
      this.lastUserBalance = new Number(0);
      this.symbolsPerReel = 64;
      this.syncWithServer = function(){
        var slot = this;
        user = null;
        $.post("AjaxRequestsProcessing.php", { slot: "sync" }, function(slotValues){
          user = eval( "("+slotValues+")");
          slot.uid = user.uid;
          slot.currentUserBalance = new Number(user.money_balance);
          slot.updateBalanceAndBet();
          //todo: try/catch and in case bad request 
          //slot.currentUserBalance = user_balance;
          //slotValues
        });
        console.log(user);
        
        
        //todo: sync all values 
        //this.getUserBalanceFromServer();
      }
      this.lastShowedSymbols = {
        reel1: {symbol1: 'pyramid', symbol2: 'anonymous', symbol3: 'anarchy'},
        reel1: {symbol1: 'pyramid', symbol2: 'anonymous', symbol3: 'anarchy'},
        reel1: {symbol1: 'pyramid', symbol2: 'anonymous', symbol3: 'anarchy'}
      }
      this.rotationTime = {
        //rotation time for every reel in ms
        reel1: 1000,
        reel2: 2000,
        reel3: 3000
      };
      this.totalSymbolsNumber = 7;
      this.state = 'stop';
      //make slot state 'stop'
      this.getStateStop = function(){
        this.state = 'stop';
      }
      //make slot state 'started'
      this.getStateStarted = function(){
        this.state = 'started';
      }
      //make 1 spin
      this.spin = function(){
        //no bet
        if (this.currentBet <= 0){
          console.log('[Current bet = 0]');
          return;
        }
        //already started
        if (this.state == 'started'){
          console.log('[Slot started already. Wait while it have stoped! ]');
          return;
        }
        //todo: syncronize the client slot values with the server slot values
        //slot started
        this.getStateStarted();
        //setTimeout('this.getStateStop()', 3000);
        //todo: timeout(reels(maxTime))
        this.getStateStop();
        
        var slot = this;
        //bet was 
        slot.lastBet = slot.currentBet;
        slot.currentBet = 0;
        slot.updateBalanceAndBet();
        slot.animateSlot();
        //todo: save the last showed symbols
      }
      this.animateSlot = function(){
        var slot = this;
        $('div.slots-line').each(function(){
          $(this).css({marginTop: -(slot.symbolsPerReel-3)*125 + 'px'});
        });
        $('div#slots-reel1 > div.slots-line').animate({marginTop: 0}, slot.rotationTime.reel1);
        $('div#slots-reel2 > div.slots-line').animate({marginTop: 0}, slot.rotationTime.reel2);
        $('div#slots-reel3 > div.slots-line').animate({marginTop: 0}, slot.rotationTime.reel3);
      }
      //fills lines of symbols
      this.linesFilling = function(){
        var slot = this;
        $('div.slots-line').each(function(){
        for (var i = 0; i < slot.symbolsPerReel; i++) {
          var id = Math.round(Math.random()*(slot.totalSymbolsNumber-1));
          $(this).append('<div class="slots-symbol'+ id +'"></div>');
        }  
        $(this).css({marginTop: -(slot.symbolsPerReel-3)*125 + 'px'});
      });
      }
      this.incBetTo = function(val){
        val = Number(val);
        val = Math.round(val*100) / 100;
        console.log(val);
        //can't inc bet
        if (this.currentUserBalance - val < 0){
          console.log("[can't inc bet]");
          return false;
        }
        
        this.currentUserBalance -= val;
        this.currentBet += val;
        this.currentUserBalance = Math.round(this.currentUserBalance * 100) / 100;
        this.currentBet = Math.round(this.currentBet * 100) / 100;
        this.updateBalanceAndBet();
      }
      this.decBetTo = function(val){
        val = Number(val);
        val = Math.round(val*100) / 100;
        if (this.currentBet - val < 0){
          return false;
        }
        this.currentUserBalance += val;
        this.currentBet -= val;
        this.currentUserBalance = Math.round(this.currentUserBalance * 100) / 100;
        this.currentBet = Math.round(this.currentBet * 100) / 100;
        this.updateBalanceAndBet();
      }
      this.setBetTo = function(val){
        //not number
        if (typeof(val) != 'number'){
          return 0;
        }
        val = Number(val);
        val = Math.round(val*100) / 100;
        //val should be >= 0
        if (val < 0){
          return 0;
        }
        //val should be < currentUserBalance
        if (this.currentUserBalance + this.currentBet - val < 0){
          console.log("[Not enough money. Max bet had been made.]");
          val = this.getMaxBet();
          //return 0;
        }
        //bet back to balance
        this.currentUserBalance = this.currentBet + this.currentUserBalance;
        //make bet
        this.currentBet = val;
        //balance minus bet
        this.currentUserBalance -= this.currentBet;
        //round all
        this.currentUserBalance = Math.round(this.currentUserBalance * 100) / 100;
        this.currentBet = Math.round(this.currentBet * 100) / 100;
        this.updateBalanceAndBet();
      }
      //retfresh values on page
      this.updateBalanceAndBet = function(){
        var slot = this;
        $('div#slots-balance').text(slot.currentUserBalance);
        $('div#slots-bet').text(slot.currentBet);
      }

      //return max bet and fill current bet field
      this.getMaxBet = function(){
        var slot = this;
        return slot.currentUserBalance + slot.currentBet;
      }
      this.makeMaxBet = function(){
        var slot = this;
        var maxBet = slot.getMaxBet();
        this.setBetTo(maxBet);
      }
      this.getLastBet = function(){
        if (this.lastBet == 0){
          console.log('[There is no last bet]');
          return 0;
        }
        var slot = this;
        return slot.lastBet;
      }
      
    }
    $(document).ready(function(){
      var uid = '<?php echo $u1->uid; ?>';
      slot = new Slot(uid);
      slot.linesFilling();
      slot.syncWithServer();
      $('button#slots-spin').on('click', function(){
        slot.spin();
      });
      
      $('button#slots-maxbet').on('click', function(){
        slot.makeMaxBet();
      });
      $('button#slots-lastbet').on('click', function(){
        slot.setBetTo(slot.getLastBet());
      });
      //plus
      $('button.slots-plus').on('click', function(){
        console.log(this.id);
        var buttonPlusId = this.id;
        switch(buttonPlusId){
          case 'slots-plus001':
            slot.incBetTo(0.01);
            break;
          case 'slots-plus01':
            slot.incBetTo(0.1);
            break;
          case 'slots-plus1':
            slot.incBetTo(1);
            break;
        }
      });
      //minus
      $('button.slots-minus').on('click', function(){
        console.log(this.id);
        var buttonPlusId = this.id;
        switch(buttonPlusId){
          case 'slots-minus001':
            slot.decBetTo(0.01);
            break;
          case 'slots-minus01':
            slot.decBetTo(0.1);
            break;
          case 'slots-minus1':
            slot.decBetTo(1);
            break;
        }
      });
      
    });
  </script>  
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<?php


?>
<body>
  <div id="slots">
    <div id="slots-reel1" class="slots-reel">
      <div class="slots-line"></div>
    </div>
    <div id="slots-reel2" class="slots-reel">
      <div class="slots-line"></div>
    </div>
    <div id="slots-reel3" class="slots-reel">
      <div class="slots-line"></div>
    </div>
    <div id="slots-body">
      <img id="slots-logo" src="images/bsm-logo.png" alt="SatoshiSlots.com">
      <img id="slots-paytable" src="images/bsm-paytable.png" alt="Paytable">
      <div id="slots-address" class="slots-display"><?php echo $u1->bitcoin_recieve_address; ?></div>
      <div id="slots-balance" class="slots-display">0<?php //echo $u1->money_balance; //todo: update without refresh!?></div>
      <div id="slots-bet" class="slots-display">0</div>
      <button id="slots-minus001" class="slots-button slots-minus"></button>
      <button id="slots-minus01" class="slots-button slots-minus"></button>
      <button id="slots-minus1" class="slots-button slots-minus"></button>
      <button id="slots-plus001" class="slots-button slots-plus"></button>
      <button id="slots-plus01" class="slots-button slots-plus"></button>
      <button id="slots-plus1" class="slots-button slots-plus"></button>
      <button id="slots-spin" class="slots-button"></button>
      <button id="slots-lastbet" class="slots-button slots-bottombutton"></button>
      <button id="slots-maxbet" class="slots-button slots-bottombutton"></button>
      <button id="slots-autoplay" class="slots-button slots-bottombutton"></button>
      <button id="slots-cashout" class="slots-button slots-bottombutton"></button>
    </div>
  </div>
</body>
</html>