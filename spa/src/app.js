import {h, render} from 'preact';
import {Router, Link} from 'preact-router';
import Home from "./pages/home";
import Conference from "./pages/conference";
import { createElement } from 'preact';

// export default function App() {
//     return (
//         <p class="big">Hello World!</p>
//     )
// }

// export default function App() {
//     return (
//         <ul className="nav nav-tabs">
//             <li className="nav-item">
//                 <a className="nav-link active btn-sm" aria-current="page" href="/profile">Me</a>
//             </li>
//             <li className="nav-item">
//                 <a className="nav-link active btn-sm" aria-current="page" href="/talks">Talks</a>
//             </li>
//             <li className="nav-item">
//                 <a className="nav-link active btn-sm" aria-current="page" href="/invite">Invites</a>
//             </li>
//             <li className="nav-item dropdown">
//                 <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
//                    aria-expanded="false">...</a>
//                 <ul className="dropdown-menu">
//                     <li><a className="dropdown-item" href="/create-talk">Create talk</a></li>
//                     <li><a className="dropdown-item" href="/invite-tree">Invite tree</a></li>
//                     {/*<li>*/}
//                     {/*    <hr className="dropdown-divider">*/}
//                     {/*</li>*/}
//                     <li><a className="dropdown-item" href="/log-out">Log out</a></li>
//                 </ul>
//             </li>
//         </ul>
//     )
// }

// render(<App/>, document.getElementById('app'));

import { Component } from 'preact'

class MyButton extends Component {
    state = { clicked: false }

    handleClick = () => {
        this.setState({ clicked: true })
    }

    render() {
        return (
            <button onClick={this.handleClick}>
                {this.state.clicked ? 'Clicked' : 'No clicks yet'}
            </button>
        )
    }
}