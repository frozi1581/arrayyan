import { Component, ViewChild, AfterViewInit } from '@angular/core';

import { jqxTreeComponent } from '../../../jqwidgets-ts/angular_jqxtree';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html'
})

export class AppComponent implements AfterViewInit {
    @ViewChild('myTree') myTree: jqxTreeComponent;

    ngAfterViewInit() {
        this.myTree.focus();
    }

    // Create jqxTree
    source: any[] = [
        {
            icon: "../images/mailIcon.png", label: "Mail", expanded: true, items: [
                { icon: "../images/calendarIcon.png", label: "Calendar" },
                { icon: "../images/contactsIcon.png", label: "Contacts", selected: true }
            ]
        },
        {
            icon: "../images/folder.png", label: "Inbox", expanded: true, items: [
                { icon: "../images/folder.png", label: "Admin" },
                { icon: "../images/folder.png", label: "Corporate" },
                { icon: "../images/folder.png", label: "Finance" },
                { icon: "../images/folder.png", label: "Other" },
            ]
        },
        { icon: "../images/recycle.png", label: "Deleted Items" },
        { icon: "../images/notesIcon.png", label: "Notes" },
        { iconsize: 14, icon: "../images/settings.png", label: "Settings" },
        { icon: "../images/favorites.png", label: "Favorites" },
    ];
}