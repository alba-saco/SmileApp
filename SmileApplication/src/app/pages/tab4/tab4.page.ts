import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';

import { StorageService } from './../../services/storage.service';
import { AlertController, NavController } from '@ionic/angular';

@Component({
  selector: 'app-tab4',
  templateUrl: './tab4.page.html',
  styleUrls: ['./tab4.page.scss'],
})
export class Tab4Page implements OnInit {

    scoreForm: FormGroup;
    final = [];
    questions = [
      'Do you think you might have gum disease?', 
      'Overall, how would you rate the health of your teeth and gums?', 
      'Have you ever had treatment for gum disease such as scaling and root planing, sometimes called “deep cleaning”?', 
      'Have you ever had any teeth become loose on their own, without an injury?', 
      'Have you ever been told by a dental professional that you lost bone around your teeth?', 
      'During the past three months, have you noticed a tooth that doesn’t look right?', 
      'Aside from brushing your teeth with a toothbrush, in the last seven days, how many times did you use dental floss or any other device to clean between your teeth?', 
      'Aside from brushing your teeth with a toothbrush, in the last seven days, how many times did you use mouthwash or other dental rinse product that you use to treat dental disease or dental problems?'
    ];
    answers = [
      'Yes',
      'No',
      "Don't know"
    ];
    answer_2 = [
      'Excellent', 
      'Very good', 
      'Good', 
      'Fair', 
      'Poor', 
      'Don’t Know'
    ];
    answer_7_8 = [
      '0-7 times',
      'More than 7 times'
    ];

    constructor(
      private router: Router,
      public formBuilder: FormBuilder,
      private storageService: StorageService,
      private alertCtrl: AlertController,
      private navCtrl: NavController,
      ) { }

    showAlert(header, sub) {
      this.alertCtrl.create({
          header: header,
          subHeader: sub,
          buttons: ['Ok']
      }).then(alert => alert.present());
    };

    settings() {
        this.router.navigate(['tabs/settings'])
    };

    submitAnswer(values) {
      if (this.scoreForm.valid) {
        for (let i = 1; i < 9; i++) {
          if (values['score'+i] !== undefined) {
            this.final.push(parseInt(values['score'+i]))
        }};
        this.storageService.store('finalAnswers', JSON.stringify(this.final));
        this.final = [];
        this.navCtrl.navigateForward('tabs/self-diagnose-res');
      } else {
        this.showAlert('Note', 'Please complete the questionnaire for a more accurate advice.')
      }
    };

  ngOnInit() {
    this.scoreForm = this.formBuilder.group({
      score1: new FormControl('', Validators.required),
      score2: new FormControl('',Validators.required),
      score3: new FormControl('',Validators.required),
      score4: new FormControl('',Validators.required),
      score5: new FormControl('',Validators.required),
      score6: new FormControl('',Validators.required),
      score7: new FormControl('',Validators.required),
      score8: new FormControl('',Validators.required),
    })
  };

}
