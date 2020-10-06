import { Component, OnInit, OnDestroy, HostListener } from '@angular/core';
import { StorageService } from 'src/app/services/storage.service';
import { AuthService } from './../../services/auth.service';
import { Location } from '@angular/common';

@Component({
  selector: 'app-self-diagnose-res',
  templateUrl: './self-diagnose-res.page.html',
  styleUrls: ['./self-diagnose-res.page.scss'],
})
export class SelfDiagnoseResPage implements OnInit, OnDestroy {
  
  stats = {
    total_count_message_A: 0, 
    Q1_count_message_A: 0, 
    Q2_count_message_A: 0,
    Q4_count_message_A: 0,
    Q5_count_message_A: 0,
    Q6_count_message_A: 0,
    Q7_count_message_C: 0,
    Q8_count_message_D: 0,
  };
  public retrievedData = new Array;
  msg_list = [
    '“Deep cleaning” is a dental procedure for removal of bacterial plaque and hardened deposits (tartar, calculus) from tooth roots and can be recommended by dentists for treatment of gum disease and prevention of tooth loss.',
  ];
  
  constructor(
    private storageService: StorageService,
    private location: Location,
    private authService: AuthService,
  ) { }

  shuffle(a) {
    let b, c, d;
    c = a.length;
    while (c) {
      b = Math.random() * c-- | 0;
      d = a[c];
      a[c] = a[b];
      a[b] = d;
    }
  };

  checkMsg1(arr) {
    if ((0 || 2) !in arr.slice(3, 6) && arr[0] === 1 && arr[1] === (0 || 1 || 2)) { } else {
      this.msg_list.push(
        'To keep your teeth and gums healthy, brush your teeth thoroughly twice daily, visit your dentist for regular check-ups and ask your dentist, therapist or hygienist to show you how to brush and clean between teeth. Gum disease is usually pain-free and you might be unaware of having it until your dentist checks for it. Over half the population has mild gum disease, and severe gum disease is the sixth most common disease in the world. Symptoms and signs of gum disease include bleeding gums, swollen gums, bad breath, loose or drifting teeth, gaps appearing between teeth, receding gums and sensitivity to cold or hot. Diabetes, smoking, stress, poor diet and obesity put people at higher risk of getting severe gum disease.',
      );
      this.stats.total_count_message_A = 1;
      if (arr[0] !== 1) {
        this.stats.Q1_count_message_A = 1;
      };
      if (arr[1] !== (0 || 1 || 2)) {
        this.stats.Q2_count_message_A = 1;
      };
      if (arr[3] !== 1) {
        this.stats.Q4_count_message_A = 1;
      };
      if (arr[4] !== 1) {
        this.stats.Q5_count_message_A = 1;
      };
      if (arr[5] !== 1) {
        this.stats.Q6_count_message_A = 1;
      };
    }
  };

  checkMsg2(arr) {
    if (arr[6] === 0) {
      this.msg_list.push(
        'Daily cleaning between teeth using floss or interdental brushes is recommended for preventing gum disease and tooth decay.',
      );
      this.stats.Q7_count_message_C = 1;
    }
  };

  checkMsg3(arr) {
    if (arr[7] === 0) {
      this.msg_list.push(
        'Mouthwash use along brushing and flossing could be beneficial, but It is not necessary to keep your teeth clean and gums healthy. If you are unsure whether to use mouthwash and how often, seek advice from your dentist, therapist or hygienist. Bleeding gums and bad breath could be a sign of gum disease.',
      );
      this.stats.Q8_count_message_D = 1;
    };
    this.authService.updateStats(this.stats).subscribe(
      (res: any) => {
        console.log(res)
    });
  };

  ionViewWillEnter() {
    for (let key in this.stats) {
      this.stats[key] = 0;
    };
    this.storageService.get('finalAnswers').then(res => {
      let Data = JSON.parse(res)
      this.retrievedData = Data;
      this.checkMsg1(this.retrievedData);
      this.checkMsg2(this.retrievedData);
      this.checkMsg3(this.retrievedData);
      this.shuffle(this.msg_list);
    });
    this.storageService.removeStorageItem('finalAnswers');
  };

  @HostListener('unloaded')
  ngOnDestroy() {
  };

  back() {
    this.location.back();
  };


  ngOnInit() {
    
  };

}
