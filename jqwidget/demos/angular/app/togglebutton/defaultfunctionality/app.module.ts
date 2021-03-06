import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { CommonModule }   from '@angular/common';

import { AppComponent } from './app.component';
import { ToggleButtonModule } from '../../modules/togglebutton.module';

@NgModule({
  declarations: [
      AppComponent
  ],
  imports: [
      BrowserModule, CommonModule, ToggleButtonModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})

export class AppModule { }


