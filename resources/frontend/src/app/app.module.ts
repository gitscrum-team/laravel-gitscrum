import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { RouterModule, Routes } from '@angular/router';

import {SuiModule} from 'ng2-semantic-ui';

import { AppComponent } from './app.component';
import { PageDashboardComponent } from './page-dashboard/page-dashboard.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { PageLoginComponent } from './page-login/page-login.component';

const appRoutes: Routes = [
  { path: '', component: PageLoginComponent },
  { path: 'dashboard', component: PageDashboardComponent },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  declarations: [
    AppComponent,
    PageDashboardComponent,
    PageNotFoundComponent,
    PageLoginComponent
  ],
  imports: [
    RouterModule.forRoot(appRoutes),
    BrowserModule,
    FormsModule,
    HttpModule,
    SuiModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
