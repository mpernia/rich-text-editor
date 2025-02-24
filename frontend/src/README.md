# Rich Text Editor Frontend

A modern Vue.js application for managing and editing posts with a rich text editor interface. Built with Vue 3, Vuetify, and Quill editor.

## Features

- 📝 Rich text editing with Quill editor
- 🔍 Post search functionality
- 📊 Post status management (draft, published, protected)
- 📱 Responsive design with Vuetify components
- 📄 Pagination with customizable rows per page
- 🎨 Modern and clean UI

## Tech Stack

- Vue.js 3 - Progressive JavaScript Framework
- Vuetify 3 - Material Design Component Framework
- Pinia - State Management
- Vue Router - Official Router
- Axios - HTTP Client
- Quill - Rich Text Editor
- Vite - Build Tool

## Prerequisites

- Node.js (v16 or higher)
- npm or yarn
- API Backend running (default: http://localhost:8000)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd rich-text-editor-frontend
```

2. Install dependencies:
```bash
npm install
# or
yarn install
```

3. Create a `.env` file in the root directory:
```env
VITE_API_URL=http://localhost:8000
```

## Development

Start the development server:
```bash
npm run dev
# or
yarn dev
```

The application will be available at `http://localhost:5173`

## Building for Production

1. Build the application:
```bash
npm run build
# or
yarn build
```

2. Preview the production build:
```bash
npm run preview
# or
yarn preview
```

## Project Structure

```
src/
├── components/          # Reusable Vue components
│   ├── PostForm.vue     # Post creation/editing form
├── router/              # Vue Router configuration
├── stores/              # Pinia state management
│   ├── posts.js         # Posts store
├── views/               # Page components
│   ├── PostList.vue     # Main post listing page
├── App.vue              # Root component
└── main.js              # Application entry point
```

## API Integration

The application expects a REST API with the following endpoints:

- `GET /posts` - List all posts
- `GET /posts?search="query"` - Search posts
- `POST /posts` - Create a new post
- `PUT /posts/:id` - Update a post
- `DELETE /posts/:id` - Delete a post

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards

- Follow Vue.js Style Guide
- Use composition API
- Write meaningful commit messages
- Add appropriate comments for complex logic
- Keep components small and focused

## Environment Variables

- `VITE_API_URL`: API backend URL (default: http://localhost:8000)

## Deployment

1. Build the application as described above
2. Deploy the contents of the `dist` directory to your web server
3. Configure your web server to serve the application and handle client-side routing

### Example Nginx Configuration

```nginx
server {
    listen 80;
    server_name your-domain.com;

    root /path/to/dist;
    index index.html;

    location / {
        try_files $uri $uri/ /index.html;
    }
}
```

## License

This project is licensed under the MIT License - see the LICENSE file for details
