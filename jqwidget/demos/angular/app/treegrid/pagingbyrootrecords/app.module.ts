import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core'; import { CommonModule } from '@angular/common';

import { AppComponent } from './app.component';
import { TreeGridModule } from '../../modules/treegrid.module';

@NgModule({
    declarations: [
        AppComponent
  ],
  imports: [
      BrowserModule, CommonModule,TreeGridModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})

export class AppModule { }


