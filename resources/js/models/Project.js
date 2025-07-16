class Project {
  constructor({
    id,
    user_id,
    name,
    housing_type,
    num_units,
    location,
    delivery_date,
    price,
    surface_area,
    description,
    created_at,
    updated_at,
    images = [],
    user = {}
  } = {}) {
    this.id = id;
    this.userId = user_id;
    this.name = name;
    this.housingType = housing_type;
    this.numUnits = num_units;
    this.location = location;
    this.deliveryDate = delivery_date;
    this.price = parseFloat(price) || 0;
    this.surfaceArea = surface_area;
    this.description = description;
    this.createdAt = created_at;
    this.updatedAt = updated_at;
    this.images = images.map(img => ({
      id: img.id,
      path: img.image_path,
      url: `http://192.168.1.15:8000${img.image_path}`,
      alt: `Property image ${img.id}`
    }));
    this.user = user;
    this.featured = false; // Will be set based on business logic
  }

  // Helper methods
  get formattedPrice() {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    }).format(this.price);
  }

  get formattedArea() {
    return `${this.surfaceArea} m²`;
  }

  get mainImage() {
    return this.images[0] || {
      url: 'https://via.placeholder.com/600x400?text=No+Image',
      alt: 'No image available'
    };
  }

  get isNew() {
    const oneWeekAgo = new Date();
    oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
    return new Date(this.createdAt) > oneWeekAgo;
  }
}

export default Project;
