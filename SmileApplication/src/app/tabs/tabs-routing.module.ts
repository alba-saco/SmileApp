import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TabsPage } from './tabs.page';
import { HomeGuard } from '../guards/home.guard';
import { UserDataResolver } from '../resolvers/user-data.resolver';

const routes: Routes = [
  {
    path: '',
    component: TabsPage,
    canActivate: [HomeGuard],
    resolve: {
      userData: UserDataResolver
    },
    children: [
      {
        path: 'tab1',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/tab1/tab1.module').then(m => m.Tab1PageModule)
          }
        ]
      },
      {
        path: 'tab2',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/tab2/tab2.module').then(m => m.Tab2PageModule)
          }, {
            path: 'topicpage/:topicID',
            loadChildren: () => import('../pages/topicpage/topicpage.module').then( m => m.TopicpagePageModule)
          }, {
            path: 'topicpage/:topicID/learningstyle/:chapterID',
            loadChildren: () =>
              import('../pages/learningstyle/learningstyle.module').then(m => m.LearningstylePageModule)
          }, {
            path: 'topicpage/:topicID/learningstyle/:chapterID/read-text',
            loadChildren: () =>
              import('../pages/read-text/read-text.module').then(m => m.ReadTextPageModule)
          }, {
            path: 'topicpage/:topicID/learningstyle/:chapterID/watch-video',
            loadChildren: () =>
              import('../pages/watch-video/watch-video.module').then(m => m.WatchVideoPageModule)
          }, {
            path: 'topicpage/:topicID/learningstyle/:chapterID/quiz',
            loadChildren: () =>
              import('../pages/quiz/quiz.module').then(m => m.QuizPageModule)
          }, {
            path: 'topicpage/:topicID/learningstyle/:chapterID/quiz/quiz-score/:score',
            loadChildren: () =>
              import('../pages/quiz-score/quiz-score.module').then(m => m.QuizScorePageModule)
          }
        ]
      },
      { 
        path: 'tab3',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/tab3/tab3.module').then(m => m.Tab3PageModule)
          }, {
            path: 'tab3-topicpage/:topicID',
            loadChildren: () => import('../pages/tab3-topicpage/tab3-topicpage.module').then( m => m.Tab3TopicpagePageModule)
          }, {
            path: 'tab3-topicpage/:topicID/quiz/:chapterID',
            loadChildren: () =>
              import('../pages/quiz/quiz.module').then(m => m.QuizPageModule)
          },
          {
            path: 'tab3-topicpage/:topicID/quiz/:chapterID/quiz-score/:score',
            loadChildren: () =>
              import('../pages/quiz-score/quiz-score.module').then(m => m.QuizScorePageModule)
          }
        ]
      },
      {
        path: 'tab4',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/tab4/tab4.module').then(m => m.Tab4PageModule)
          }
        ]
      },
      {
        path: 'settings',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/settings/settings.module').then(m => m.SettingsPageModule)
          }
        ]
      },
      {
        path: 'topicpage',
        children: [
          {
            path: 'topicpage',
            loadChildren: () =>
              import('../pages/topicpage/topicpage.module').then(m => m.TopicpagePageModule)
          }
        ]
      },
      {
        path: 'read-text',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/read-text/read-text.module').then(m => m.ReadTextPageModule)
          }
        ]
      },
      {
        path: 'learningstyle',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/learningstyle/learningstyle.module').then(m => m.LearningstylePageModule)
          }
        ]
      },
      {
        path: 'watch-video',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/watch-video/watch-video.module').then(m => m.WatchVideoPageModule)
          }
        ]
      },
      {
        path: 'quiz',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/quiz/quiz.module').then(m => m.QuizPageModule)
          }
        ]
      },
      {
        path: 'quiz-score',
        children: [
          {
            path: '',
            loadChildren: () =>
              import('../pages/quiz-score/quiz-score.module').then(m => m.QuizScorePageModule)
          }
        ]
      },
      {
        path: 'reminder-setup',
        children: [
          {
            path: '',
            loadChildren: () => 
            import('../pages/reminder-setup/reminder-setup.module').then( m => m.ReminderSetupPageModule)
          }
        ]
      },
      {
        path: 'reminders',
        children: [
          {
            path: '',
            loadChildren: () => 
            import('../pages/reminders/reminders.module').then( m => m.RemindersPageModule)
          }
        ]
      },
      {
        path: 'privacy-agreement',
        children: [
          {
            path: '',
            loadChildren: () => import('../pages/privacy-agreement/privacy-agreement.module').then( m => m.PrivacyAgreementPageModule)
          }
        ]
      },
      {
        path: 'personal-info',
        children: [
          {
            path: '',
            loadChildren: () => import('../pages/personal-info/personal-info.module').then( m => m.PersonalInfoPageModule)
          }
        ]
      },
      {
        path: 'manage-password',
        children: [
          {
            path: '',
            loadChildren: () => import('../pages/manage-password/manage-password.module').then( m => m.ManagePasswordPageModule)
          }
        ]
      },
      {
        path: 'self-diagnose-res',
        children: [
          {
            path: '',
            loadChildren: () => import('../pages/self-diagnose-res/self-diagnose-res.module').then( m => m.SelfDiagnoseResPageModule)
          }
        ]
      },
      {
        path: '',
        redirectTo: '/tabs/tab1',
        pathMatch: 'full'
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TabsPageRoutingModule {}
