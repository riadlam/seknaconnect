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
    bedrooms,
    bathrooms,
    rent_or_buy,
    payment_plan,
    project_timeline,
    description,
    created_at,
    updated_at,
    images = [],
    user = {},
    f1_count,
    f2_count,
    f3_count,
    f4_count,
    additional_housing_types
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
    this.bedrooms = bedrooms;
    this.bathrooms = bathrooms;
    this.rentOrBuy = rent_or_buy;
    this.paymentPlan = payment_plan;
    this.projectTimeline = project_timeline;
    this.description = description;
    this.createdAt = created_at;
    this.updatedAt = updated_at;
    this.images = images.map(img => ({
      id: img.id,
      path: img.image_path,
      url: `http://172.16.12.249:8000${img.image_path}`,
      alt: `Property image ${img.id}`
    }));
    this.user = user;
    this.featured = false; // Will be set based on business logic
    this.f1Count = f1_count || 0;
    this.f2Count = f2_count || 0;
    this.f3Count = f3_count || 0;
    this.f4Count = f4_count || 0;
    // Parse additional_housing_types if it's a JSON string
    try {
      this.additionalHousingTypes = typeof additional_housing_types === 'string' 
        ? JSON.parse(additional_housing_types) 
        : (additional_housing_types || []);
    } catch (e) {
      this.additionalHousingTypes = Array.isArray(additional_housing_types) ? additional_housing_types : [];
    }
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
