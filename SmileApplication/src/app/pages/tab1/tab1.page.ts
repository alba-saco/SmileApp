// The file tab1.page.ts has been adapted from https://www.youtube.com/watch?v=qTdwUpQRptc&t=2060s (more specifically the Timer Logic and Timer Display Logic)
// The file tab1.page.ts has been adapted from https://github.com/bootsoon/ng-circle-progress 

import { Component, OnInit, NgModule, ErrorHandler } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { CommonModule } from '@angular/common';
import { IonicModule } from '@ionic/angular';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

import { Router } from '@angular/router';

import { AuthService } from './../../services/auth.service';

import { connectableObservableDescriptor } from 'rxjs/internal/observable/ConnectableObservable';
import { StorageService } from 'src/app/services/storage.service';
import { BehaviorSubject } from 'rxjs';
import { StatsService } from 'src/app/stats.service';

@Component({
  selector: 'app-tab1',
  templateUrl: 'tab1.page.html',
  styleUrls: ['tab1.page.scss']
})
export class Tab1Page implements OnInit {

  public statsService: StatsService;

  public authUser: any;
  userName$ = new BehaviorSubject<any>([]);

  timerOn: boolean = false;
  timerPaused: boolean = true;
  timerDone: boolean = false;
  timerStart: boolean = false;
 
  percent: number= 0;
  radius: number = 100;
  fullTime: any = '03:00';

  timer: any = false;
  progress : any = 0;
  minutes: number = 3;
  seconds: any = 0;
  timeLeft: number = 180;

  elapsed: any = {
    m: '03',
    s: '00'
  }

  currentMessageTime: number = 0;  
  currentMessage : string = "Spin that brush!";    
  brushing_instruction = ["outside <br> top middle", "outside <br> top right", "outside <br> top left",
                           "outside <br> buttom middle", "outside <br> buttom right", "outside <br> buttom left",
                            "chewing surface <br> bottom middle", "chewing surface <br> bottom right", "chewing surface <br> bottom left",
                             "chewing surface <br> top middle", "chewing surface <br> top right", "chewing surface <br> top left",
                              "inside <br> top middle", "inside <br> top right", "inside <br> top left",
                               "inside <br> buttom middle", "inside <br> buttom right", "inside <br> buttom left", ""]; 

// Source for FDI World Dental Federation: https://www.fdiworlddental.org/oral-health/ask-the-dentist/facts-figures-and-stats
// Source for American Dental Association: https://www.mouthhealthy.org/en/fun-teeth-facts-part-2 

  factList = {"FDI World Dental Federation (1)": "Oral disease affects 3.9 billion people worldwide, with untreated tooth decay (dental caries) impacting almost half of the world’s population (44%).",
  "FDI World Dental Federation (2)": "Globally, between 60–90% of schoolchildren and nearly 100% adults have tooth decay, often leading to pain and discomfort.",
  "FDI World Dental Federation (3)": "Severe periodontal (gum) disease, which may result in tooth loss, is found in 15–20% of middle-aged (35–44 years) adults.",
  "FDI World Dental Federation (4)": "Globally, about 30% of people aged 65–74 years have no natural teeth, a burden expected to increase in the light of ageing populations.", 
  "FDI World Dental Federation (5)": "Oral conditions are the fourth most expensive to treat. In the United States alone, US$110 billion are spent yearly on oral healthcare. In the European Union, annual spending on oral healthcare was estimated at €79 billion in the years 2008-2012, which is more than the money invested in the care of cancer or respiratory diseases.",
  "FDI World Dental Federation (6)": "Risk factors for oral disease include an unhealthy diet – particularly one rich in sugars – tobacco use, harmful alcohol use and poor oral hygiene.",
  "FDI World Dental Federation (7)": "Over the past 50 years, worldwide sugar consumption has tripled, an increase which is expected to grow – particularly in emerging economies (OHA 2015).",
  "FDI World Dental Federation (8)": "Dental caries is the most common chronic disease in the world – due to exposure to sugar and other risks – and is a major global public health problem affecting individuals, health systems and economies.",
  "FDI World Dental Federation (9)": "The World Health Organization recommends that the daily intake of free sugars be limited to less than 10% (or 50 g = around 12 teaspoons) of total energy intake in both adults and children. A further reduction to below 5% (or 25 g = around 6 teaspoons) of total energy intake would provide additional health benefits and help minimize the risk of dental caries throughout life.",
  "FDI World Dental Federation (10)": "Free sugars intake of above 60 g per person per day increases the rate of dental caries in teenagers and adults.",
  "FDI World Dental Federation (11)": "Consuming free sugars more than four times a day leads to an increased risk of dental caries.",
  "FDI World Dental Federation (12)": "65 countries in the world consume more than 100 g of sugars per person per day (twice the WHO-recommended amount).",
  "FDI World Dental Federation (13)": "Excessive sugars intake causes serious dependence and quitting sugars consumption leads to withdrawal symptoms similar to withdrawal from morphine or nicotine.",
  "FDI World Dental Federation (14)": "Sugary drinks (such as soda, juice, energy and sports drinks) are a main source of ‘empty calories’, which contain high levels of energy and no nutritional value.",
  "FDI World Dental Federation (15)": "Excessive consumption of sugars from snacks, processed foods, and drinks causes worldwide increases in oral diseases, cardiovascular (heart) disease, cancer and diabetes.",
  "FDI World Dental Federation (16)": "Consuming one can (355 mL) of a sugary drink per day can lead to a 6.5 kg weight gain in one year",
  "FDI World Dental Federation (17)": "Drinking sugary drinks regularly (e.g. almost one can per day) increases the risk of developing type 2 diabetes by 22%.",
  "FDI World Dental Federation (18)": "Almost 100% of adults and 60-90% of schoolchildren in the world have dental caries.",
  "FDI World Dental Federation (19)": "Dental caries is the fourth most expensive oral disease to treat and consumes 5–10% of healthcare budgets in industrialized countries.",
  "American Dental Association (1)": "The shiny, white enamel that covers your teeth is even stronger than bone and the hardest substance in your body. This resilient surface is 96 percent mineral, the highest percentage of any tissue in your body – making it durable and damage-resistant.",
  "American Dental Association (2)": "Thanks to the durability of tooth enamel, our teeth actually outlast us. For example, we know that the first travelers to leave Africa for China set out as many as 80,000 years ago – and that early humans used a simple form of aspirin for pain relief – thanks to teeth!",
  "American Dental Association (3)": "All other tissues in our bodies have the power to repair themselves, but our teeth can’t. When damaged, they must be repaired by a skilled dentist using caps, crowns, fillings or veneers.", 
  "American Dental Association (4)": "Did you know there are more than 300 kinds of bacteria that can attack your teeth?"};

  currentFact: string = this.chooseFact();

    constructor(
      private router: Router,
      private auth: AuthService,
      private storageService: StorageService,
      statsService: StatsService
      ) { 
        this.statsService = statsService;
      }

  settings() {
      this.router.navigate(['tabs/settings'])
  }


  getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min) ) + min;
  }

  chooseFact(){
    let listLength = Object.keys(this.factList).length;
    let keyList = Object.keys(this.factList);
    let randomIndex = this.getRndInteger(0, listLength);
    console.log(this.factList[randomIndex])
    return this.factList[keyList[randomIndex]];
  }

  // The timer to replace the information facts has been set to 20 min., equivalent to 1200000 ms. (1000 ms. == 1 sec.)
  factTimer: any = setInterval(() =>{
    this.currentFact = this.chooseFact();
  }, 1200000)

  initiateTimer(){
    this.timerOn = true;
    this.timer = false;
    this.timerPaused = true;
    this.timerDone = false;
    this.timerStart = false;
    this.percent = 0;
    this.progress = 0;
    this.timeLeft = 180;
    this.currentMessage = "Spin that brush!";
    this.fullTime = '03:00';

    let timeSplit = this.fullTime.split(':');
    this.minutes = timeSplit[0];
    this.seconds = timeSplit[1];
  }

  startTimer(){

    this.statsService.addTimer();

    if(this.timer){
      clearInterval(this.timer);
    }

    this.timerPaused = false;
    this.timerDone = false;
    this.timerStart = true;
    let totalSeconds = Math.floor(this.minutes * 60) + parseInt(this.seconds);

    this.timer = setInterval(() => {

      if(this.timeLeft == 0){
        clearInterval(this.timer);
        this.finishedTimer();
        this.fullTime = ["Well", "done!"];
        this.currentMessage = "Wow your teeth <br> look white and shiny!"
        this.timerDone = true;

      }
      else{
        this.percent = Math.floor((this.progress / totalSeconds) * 100);
        this.progress++;
        this.timeLeft = totalSeconds - this.progress;


        this.currentMessageTime = Math.floor(this.progress / 10);
        
        this.currentMessage = "Brush " + this.brushing_instruction[this.currentMessageTime] + "!";
  
        this.elapsed.m = Math.floor((this.timeLeft/60));
        this.elapsed.s = Math.floor((this.timeLeft % 60));
  
        this.elapsed.m = this.pad(this.elapsed.m, 2);
        this.elapsed.s = this.pad(this.elapsed.s, 2);

        this.fullTime = this.elapsed.m + ":" + this.elapsed.s;
      }

    }, 1000)
  }

  pad(num, size){
    let s = num+"";
    while(s.length < size) s = "0"+s;
    return s;
  }


  stopTimer(){
    this.timerPaused = true;
    this.timerStart = false;
    clearInterval(this.timer);
  }


  exitTimer(){
    clearInterval(this.timer);
    this.timerOn = false;
    this.timer = false;
    this.timerPaused = true;
    this.timerDone = false;
    this.timerStart = false;
    this.percent = 0;
    this.progress = 0;
    this.timeLeft = 180;
    this.currentMessage = "Spin that brush!";
    this.fullTime = '03:00';


  }

  finishedTimer(){
    this.timerDone = true;
    
  }

  ngOnInit() {
    this.auth.userData$.subscribe((res:any) => {
      this.authUser = res;
    });
    this.storageService.get('firstName').then(res => {
      this.userName$.next(res);
    });
  }

}

console.log("Test")