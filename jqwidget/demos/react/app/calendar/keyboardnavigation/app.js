import React from 'react';
import ReactDOM from 'react-dom';

import JqxCalendar from '../../../jqwidgets-react/react_jqxcalendar.js';

class App extends React.Component {
    render() {
        return (
            <div>
                <JqxCalendar style={{ float: 'left' }}
                    width={220} height={220}
                />

                <div style={{ fontFamily: 'Verdana', fontSize: 12, width: 400, marginLeft: 20, float: 'left' }}>
                    <ul>
                        <li><b>Tab</b> - Like other widgets, the jqxCalendar widget receives focus by tabbing into it. Once focus is received, users will be able to use the keyboard to change the Calendar's selection. A second tab will take the user out of the date picker widget.</li>
                        <li><b>Shift+Tab</b> - reverses the direction of the tab order. Once in the widget, a Shift+Tab will take the user to the previous focusable element in the tab order.</li>
                        <li><b>Up Arrow</b> and <b>Down Arrow</b> - goes to the same day of the week in the previous or next week respectively. If the user advances past the end of the month they continue into the next or previous month as appropriate.</li>
                        <li><b>Left Arrow</b> and <b>Right Arrow</b> - advances one day to the next.</li>
                        <li><b>Home</b> - Moves to the first day of the current month.</li>
                        <li><b>End</b> - Moves to the last day of the current month.</li>
                        <li><b>Page Up</b> - Moves to the same date in the previous month.</li>
                        <li><b>Page Down</b> - Moves to the same date in the next month.</li>
                    </ul>
                </div>

            </div>
        )
    }
}

ReactDOM.render(<App />, document.getElementById('app'));
