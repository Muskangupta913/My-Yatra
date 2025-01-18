<style>
                    .room-category {
                        margin-bottom: 2rem;
                    }
                    
                    .category-title {
                        font-size: 1.5rem;
                        font-weight: 600;
                        color: #1e293b;
                        margin-bottom: 1rem;
                        padding-bottom: 0.5rem;
                        border-bottom: 2px solid #e2e8f0;
                    }
                    
                    .room-card {
                        display: flex;
                        flex-direction: column;
                        background: white;
                        border-radius: 1rem;
                        padding: 1rem;
                        margin-bottom: 1.5rem;
                        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
                        border: 1px solid #f1f5f9;
                    }
                    
                    .room-images {
                        width: 100%;
                        margin-bottom: 1rem;
                    }
                    
                    .main-image-container {
                        position: relative;
                        width: 100%;
                        padding-top: 66.67%; /* 3:2 aspect ratio */
                        border-radius: 0.5rem;
                        overflow: hidden;
                    }
                    
                    .main-image {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                    
                    .thumbnail-gallery {
                        display: flex;
                        gap: 0.5rem;
                        margin-top: 0.5rem;
                        overflow-x: auto;
                        -webkit-overflow-scrolling: touch;
                        scrollbar-width: none;
                        padding-bottom: 0.5rem;
                    }
                    
                    .thumbnail-gallery::-webkit-scrollbar {
                        display: none;
                    }
                    
                    .thumbnail {
                        flex: 0 0 60px;
                        height: 60px;
                        object-fit: cover;
                        border-radius: 0.25rem;
                        cursor: pointer;
                        transition: opacity 0.2s;
                    }
                    
                    .room-details {
                        flex: 1;
                    }
                    
                    .room-header {
                        display: flex;
                        flex-direction: column;
                        gap: 1rem;
                        margin-bottom: 1rem;
                    }
                    
                    .price-section {
                        text-align: left;
                    }
                    
                    .amenities-list {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 0.5rem;
                    }
                    
                    .amenity-tag {
                        display: inline-flex;
                        align-items: center;
                        background: #f1f5f9;
                        padding: 0.5rem 1rem;
                        border-radius: 0.25rem;
                        font-size: 0.875rem;
                        white-space: nowrap;
                    }
                    
                    .cancellation-policy {
                        margin-top: 1rem;
                        padding: 1rem;
                        background: #f8fafc;
                        border-radius: 0.5rem;
                    }
                    
                    .book-section {
                        margin-top: 1.5rem;
                        padding-top: 1.5rem;
                        border-top: 1px solid #e2e8f0;
                        display: flex;
                        flex-direction: column;
                        gap: 1rem;
                        align-items: stretch;
                    }
                    
                    .book-button {
                        background: #2563eb;
                        color: white;
                        padding: 0.75rem 1.5rem;
                        border-radius: 0.5rem;
                        border: none;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.5rem;
                        width: 100%;
                    }
                    
                    .error-message {
                        text-align: center;
                        padding: 2rem;
                        color: #ef4444;
                    }
                    
                    /* Tablet and up */
                    @media (min-width: 768px) {
                        .room-card {
                            flex-direction: row;
                            padding: 1.5rem;
                        }
                        
                        .room-images {
                            flex: 0 0 300px;
                            margin-bottom: 0;
                            margin-right: 1.5rem;
                        }
                        
                        .room-header {
                            flex-direction: row;
                            justify-content: space-between;
                        }
                        
                        .price-section {
                            text-align: right;
                        }
                        
                        .book-section {
                            flex-direction: row;
                            justify-content: space-between;
                            align-items: center;
                        }
                        
                        .book-button {
                            width: auto;
                        }
                    }
                    
                    /* Desktop and up */
                    @media (min-width: 1024px) {
                        .room-images {
                            flex: 0 0 400px;
                        }
                        
                        .amenities-list {
                            gap: 0.75rem;
                        }
                    }
                </style>