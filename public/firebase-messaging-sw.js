// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyBXm8eXzKgCGmmh7VxAF6_nXaKEE_cx2bg",
    authDomain: "my-chat-68fe6.firebaseapp.com",
    projectId: "my-chat-68fe6",
    storageBucket: "my-chat-68fe6.appspot.com",
    messagingSenderId: "505887812683",
    appId: "1:505887812683:web:fa011e9b6b4e786e58b1ce"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const {title , body } = payload.notification;
    const notificationOptions = {
      body,
    };

    self.registration.showNotification(title,notificationOptions);
  });
