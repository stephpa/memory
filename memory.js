function test(){
    
    var Memory = {

	init: function(cards){
	    console.log("init");
	    this.$game = $(".game");
	    this.$modal = $(".modal");
	    this.$overlay = $(".modal-overlay");
	    this.$restartButton = $("button.restart");
	    this.cardsArray = $.merge(cards, cards);
	    this.shuffleCards(this.cardsArray);
            this.$winner = document.getElementById("wincnt");
	    this.setup();
	    this.dbinit();
	    },

	shuffleCards: function(cardsArray){
	    console.log("shuffleCards");
	    this.$cards = $(this.shuffle(this.cardsArray));
	    },

	setup: function(){
	    console.log("setup");
	    this.html = this.buildHTML();
	    this.$game.html(this.html);
	    this.$memoryCards = $(".card");
	    this.binding();
	    this.paused = false;
	    this.guess = null;
	    localStorage.setItem("cnt", 0);
            },

        dbinit: function(){
	    console.log("dbinit");
	    var $userlang = navigator.language || navigator.userLanguage; 
            //entry in db
            var $gnr = document.getElementById("gnr").innerHTML;
	    console.log($userlang);
            jQuery.ajax({
                type: "POST",
                url: "/storeCnt.php",
                dataType: 'json',
                data: {functionname: 'in', arguments: [$gnr,$userlang]},
                success: function(obj,textstatus){
                    if ( !('error' in obj) ) {
                        console.log("ajax call returned OK");
                        //alert("OK");
                    }
                    else{
                        //alert($cnt);
                        console.log("ajax call returned NOK");
                    }
                }
                });
	    },

	binding: function(){
	    console.log("binding");
	    this.$memoryCards.on("click", this.cardClicked);   
	    $("button.restart").unbind().click( $.proxy(this.reset, this));
	    },
	// kinda messy but hey
	cardClicked: function(){
	    console.log("cardclicked");
	    var _ = Memory;
	    var $card = $(this);
            var $cnt = parseInt(localStorage.getItem("cnt"));
	    $cnt = $cnt + 1;
	    localStorage.setItem("cnt", $cnt);
	    if(!_.paused && !$card.find(".inside").hasClass("matched") && !$card.find(".inside").hasClass("picked")){
		$card.find(".inside").addClass("picked");
		if(!_.guess){
		    _.guess = $(this).attr("data-id");
		    } else if(_.guess == $(this).attr("data-id") && !$(this).hasClass("picked")){
			$(".picked").addClass("matched");
			_.guess = null;
			} else {
			    _.guess = null;
			    _.paused = true;
			    setTimeout(function(){
				$(".picked").removeClass("picked");
				Memory.paused = false;
				}, 600);
			    }
		if($(".matched").length == $(".card").length){
		    _.win();
		    }
		}
	    },

	win: function(){
	    console.log("win");
	    this.paused = true;
	    setTimeout(function(){
		Memory.showModal();
		Memory.$game.fadeOut();
		}, 1000);
	    },

	showModal: function(){
	    console.log("showModal");
	    var $cnt = localStorage.getItem("cnt");
	    var $gnr = document.getElementById("gnr").innerHTML;
	    var $userlang = navigator.language || navigator.userLanguage; 
	    console.log($userlang);
	    //set for next game if continued
	    document.getElementById("gnr").innerHTML = parseInt($gnr) + 1;
            jQuery.ajax({
		type: "POST", 
		url: "/storeCnt.php", 
		dataType: 'json',
		data: {functionname: 'cnt', arguments: [$cnt,$gnr,$userlang]},
		success: function(obj,textstatus){
		    if ( !('error' in obj) ) {
			console.log("ajax call returned OK");
		    }
		    else{
			console.log("ajax call returned NOK");
		    }
		}
	    });

	    this.$winner.innerHTML="Gewonnen in " + $cnt + " clicks!";
	    this.$overlay.show();
	    this.$modal.fadeIn("slow");
	    },

	hideModal: function(){
	    console.log("hideModal");
	    this.$overlay.hide();
	    this.$modal.hide();
	    },

	reset: function(){
	    console.log("reset");
	    this.dbinit();
	    this.hideModal();
	    cards = this.SetCards();
	    this.cardsArray = $.merge(cards, cards);
	    this.shuffleCards(this.cardsArray);
	    this.setup();
	    this.$game.show("slow");
	    },

	// Fisher--Yates Algorithm -- https://bost.ocks.org/mike/shuffle/
	shuffle: function(array){
	    console.log("shuffle");
	    var counter = array.length, temp, index;
	    // While there are elements in the array
	    while (counter > 0) {
		// Pick a random index
		index = Math.floor(Math.random() * counter);
		// Decrease counter by 1
		counter--;
		// And swap the last element with it
		temp = array[counter];
		array[counter] = array[index];
		array[index] = temp;
		}
	    return array;
	    },


	buildHTML: function(){
	    console.log("buildHTML");
	    var frag = '';
	    this.$cards.each(function(k, v){
		frag += '<div class="card" data-id="'+ v.id +'"><div class="inside">\
<div class="front"><img src="'+ v.img +'"\
alt="'+ v.name +'" /></div>\
<div class="back"><img src="images/memory/0.jpg"\
alt="SR" /></div></div>\
</div>';
		});
	    return frag;
	    },
	
	getRandomArrayElements: function(arr, count) {
	    console.log("getRandomArrayElements");

	    var shuffled = arr.slice(0), i = arr.length, min = i - count, temp, index;
	    while (i-- > min) {
		index = Math.floor((i + 1) * Math.random());
		temp = shuffled[index];
		shuffled[index] = shuffled[i];
		shuffled[i] = temp;
	    }
	    return shuffled.slice(min);
	},

	SetCards: function(){
	    console.log("SetCards");
	    var numicar = this.getRandomArrayElements(numbers, 12);
	    var miscards = [
		{
		    name: "Pfeil",
		    img: "images/memory/" + numicar[0] + ".jpg",
		    id: 1,
		},
		{
		    name: "Baywatch",
		    img: "images/memory/" + numicar[1] + ".jpg",
		    id: 2
		},
		{
		    name: "Badeverbot",
		    img: "images/memory/" + numicar[2] + ".jpg",
		    id: 3
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[3] + ".jpg",
		    id: 4
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[4] + ".jpg",
		    id: 5
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[5] + ".jpg",
		    id: 6
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[6] + ".jpg",
		    id: 7
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[7] + ".jpg",
		    id: 8
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[8] + ".jpg",
		    id: 9
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[9] + ".jpg",
		    id: 10
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[10] + ".jpg",
		    id: 11
		},
		{
		    name: "Donut",
		    img: "images/memory/" + numicar[11] + ".jpg",
		    id: 12
		}
	    ];
	    return miscards;
	}
    };

    var numbers = ['1','2','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30'];
    var numcar = Memory.getRandomArrayElements(numbers, 12);
    var cards = [
	{
	    name: "Pfeil",
	    img: "images/memory/" + numcar[0] + ".jpg",
	    id: 1,
	},
	{
	    name: "Baywatch",
	    img: "images/memory/" + numcar[1] + ".jpg",
	    id: 2
	},
	{
	    name: "Badeverbot",
	    img: "images/memory/" + numcar[2] + ".jpg",
	    id: 3
	},
	{
	    name: "Donut",
	    img: "images/memory/" + numcar[3] + ".jpg",
	    id: 4
	}, 
	{
	    name: "OrangeBoye",
	    img: "images/memory/" + numcar[4] + ".jpg",
	    id: 5
	},
	{
	    name: "SeiEineBoye",
	    img: "images/memory/" + numcar[5] + ".jpg",
	    id: 6
	},
	{
	    name: "Wandboyen",
	    img: "images/memory/" + numcar[6] + ".jpg",
	    id: 7
	},
	{
	    name: "GelbeSammlung",
	    img: "images/memory/" + numcar[7] + ".jpg",
	    id: 8
	},
	{
	    name: "Glaskugeln3",
	    img: "images/memory/" + numcar[8] + ".jpg",
	    id: 9
	},
	{
	    name: "Glaskugeln2",
	    img: "images/memory/" + numcar[9] + ".jpg",
	    id: 10
	},
	{
	    name: "Mannboyen",
	    img: "images/memory/" + numcar[10] + ".jpg",
	    id: 11
	},
	{
	    name: "Tekkiboye",
	    img: "images/memory/" + numcar[11] + ".jpg",
	    id: 12
	},
    ];
    
    Memory.init(cards);
}

