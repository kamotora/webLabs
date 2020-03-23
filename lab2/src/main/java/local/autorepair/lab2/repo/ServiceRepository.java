package local.autorepair.lab2.repo;

import local.autorepair.lab2.core.Service;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ServiceRepository extends JpaRepository<Service, Long> {
}
